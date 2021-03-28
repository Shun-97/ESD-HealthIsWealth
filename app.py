from flask import Flask, request, render_template, redirect, url_for, session
from flask_sqlalchemy import SQLAlchemy
import graphene
from graphene_sqlalchemy import SQLAlchemyObjectType, SQLAlchemyConnectionField
from flask_graphql import GraphQLView
from datetime import timedelta

app = Flask(__name__)
# For login session
app.secret_key = "healthiswealth"
app.permanent_session_lifetime = timedelta(minutes=30)
# Database connection
app.config['SQLALCHEMY_DATABASE_URI'] = 'postgresql://qepnpscgacacmr:d338fb6ef24db3eed89c7a4200ac74e8cb5c1ffd22bf8e26194eb684c6b8e33d@ec2-52-21-252-142.compute-1.amazonaws.com:5432/ddo160cbfi69qt'
app.config['SQLALCHEMY_COMMIT_ON_TEARDOWN'] = True
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = True
db = SQLAlchemy(app)

# Model


class Registration(db.Model):
    __tablename__ = 'Registration'

    Username = db.Column(db.String(256), primary_key=True)
    Password = db.Column(db.String(256))
    Email = db.Column(db.String(256))

    def __repr__(self):
        return '<Registration %r>' % self.Username


class UserAccount(db.Model):
    __tablename__ = 'UserAccount'

    Username = db.Column(db.String(256), primary_key=True)
    Height = db.Column(db.Float)
    Weight = db.Column(db.Float)
    BMI = db.Column(db.Float)

    def __repr__(self):
        return '< UserAccount %r>' % self.Username

# Schema Objects


class RegistrationObject(SQLAlchemyObjectType):
    class Meta:
        model = Registration
        interfaces = (graphene.relay.Node, )


class UserAccountObject(SQLAlchemyObjectType):
    class Meta:
        model = UserAccount
        interfaces = (graphene.relay.Node, )

# Graphql Query


class Query(graphene.ObjectType):
    node = graphene.relay.Node.Field()
    all_registration = SQLAlchemyConnectionField(RegistrationObject)
    all_userAccount = SQLAlchemyConnectionField(UserAccountObject)

    registration_by_username = graphene.List(RegistrationObject, username=graphene.String())
    userAccount_by_username = graphene.List(UserAccountObject, username=graphene.String())


    @staticmethod
    def resolve_registration_by_username(parent, info, **args):
        q = args.get('username')

        registration_query = RegistrationObject.get_query(info)

        return registration_query.filter(Registration.Username == q).all()

    def resolve_userAccount_by_username(parent,info,**args):
        q = args.get('username')

        userAccount_query = UserAccountObject.get_query(info)

        return userAccount_query.filter(UserAccount.Username == q).all()

#Graphql Mutation

class CreateRegistration(graphene.Mutation):
    class Arguments:
        Username = graphene.String(required=True)
        Password = graphene.String(required=True)
        Email = graphene.String(required=True)

    registration = graphene.Field(lambda: RegistrationObject)

    def mutate(self, info, Username, Password, Email):
        registration = Registration(
            Username=Username, Password=Password, Email=Email)

        db.session.add(registration)
        db.session.commit()

        return CreateRegistration(registration=registration)


class CreateUserAccount(graphene.Mutation):
    class Arguments:
        Username = graphene.String(required=True)
        Weight = graphene.Float(required=False)
        Height = graphene.Float(required=False)
        BMI = graphene.Float(required=False)

    userAccount = graphene.Field(lambda: UserAccountObject)

    def mutate(self, info, Username, Weight=0, Height=0, BMI=0):
        userAccount = UserAccount(
            Username=Username, Weight=Weight, Height=Height, BMI=BMI)

        db.session.add(userAccount)
        db.session.commit()

        return CreateUserAccount(userAccount=userAccount)


class updateUserAccount(graphene.Mutation):
    class Arguments:
        Username = graphene.String(required=True)
        Weight = graphene.Float(required=False)
        Height = graphene.Float(required=False)
        BMI = graphene.Float(required=False)

    userAccount = graphene.Field(UserAccountObject)
    
    def mutate(self, info, Username, Weight, Height, BMI):
        userAccount = db.session.query(UserAccount).filter_by(Username=Username).first()
        userAccount.Height = Height
        userAccount.Weight = Weight
        userAccount.BMI = BMI

        db.session.commit()
        return updateUserAccount(userAccount=userAccount)


class Mutation(graphene.ObjectType):
    create_registration = CreateRegistration.Field()
    create_userAccount = CreateUserAccount.Field()
    update_userAccount = updateUserAccount.Field()


schema = graphene.Schema(query=Query, mutation=Mutation)

# Routes
@app.route('/')
def index():
    return render_template('index.html')


@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        username = request.form['username'].lower()
        password = request.form['password']

        schema = graphene.Schema(query=Query)
        query_string = '{registrationByUsername(username:"' + \
            username + '"){Username Password Email}}'
        validate = schema.execute(query_string)

        # Check if user exist
        if not validate.data['registrationByUsername']:
            error = "user don't exist"
            return render_template('login.php', error=error)

        # Check if password matches
        elif validate.data['registrationByUsername'][0]['Password'] == password:
            session.permanent = True
            session["user"] = username
            return redirect(url_for("profile"))

        else:
            error = "Wrong password"
            return render_template('login.php', error=error)

        return render_template('login.php')

    else:
        return render_template('login.php')


@app.route('/register', methods=['GET', 'POST'])
def register():
    if request.method == 'POST':
        username = request.form['username'].lower()
        email = request.form['email']
        password = request.form['password']
        # print(username, email, password)

        schema = graphene.Schema(query=Query, mutation=Mutation)
        query_string = '{registrationByUsername(username:"' + \
            username + '"){Username Password Email}}'
        validate = schema.execute(query_string)

        # Check if user exist
        if validate.data['registrationByUsername']:
            error = "user exist, Please login instead"
            return render_template('register.html', error=error)

        else:

            create_registration = 'mutation{createRegistration(Email:"'+email+'", Username:"'+username+'",Password:"'+password+'"){registration{Email Username Password}}}'
            create_userAccount = 'mutation{createUseraccount(Username:"'+username+'"){userAccount{Username}}}'
            register = schema.execute(create_registration)
            userAccount = schema.execute(create_userAccount)

            # print(register)
            if register.data:
                session.permanent = True
                session["user"] = username
                return redirect(url_for("profile"))

            else:
                error = "Failed to create account. Please try again"
                return render_template('register.html', error=error)

        return render_template('register.html')

    else:
        return render_template('register.html')


@app.route('/profile')
def profile():
    if "user" in session:
        user = session["user"]


        #Get existing data
        schema = graphene.Schema(query=Query, mutation=Mutation)
        query_string = '{userAccountByUsername(username:"'+user+'"){Username Weight Height BMI}}'
        result = schema.execute(query_string)
        height = result.data["userAccountByUsername"][0]["Height"]
        weight = result.data["userAccountByUsername"][0]["Weight"]
        bmi = result.data["userAccountByUsername"][0]["BMI"]
        
        return render_template('profile.html', user=user, height=height, weight=weight, bmi= bmi)
    else:
        return render_template('index.html')

@app.route('/profile/update/<username>', methods=['POST','GET'])
def update_profile(username):
    if request.method == "POST":
        user = session["user"]
        height = request.form["height"]
        weight = request.form["weight"]
        bmi = request.form["bmi"]

        schema = graphene.Schema(query=Query, mutation=Mutation)
        update_query = 'mutation{updateUseraccount(Username:"'+username+'",BMI:'+bmi+',Height:'+height+',Weight:'+weight+'){userAccount{Username BMI Height Weight}}}'
        update = schema.execute(update_query)
        print(update)

        if update.data:
            query_string = '{userAccountByUsername(username:"'+user+'"){Username Weight Height BMI}}'
            result = schema.execute(query_string)
            height = result.data["userAccountByUsername"][0]["Height"]
            weight = result.data["userAccountByUsername"][0]["Weight"]
            bmi = result.data["userAccountByUsername"][0]["BMI"]
            
            return redirect(url_for("profile"))

        else:
            error = "Unable to update, please try again later"
            return render_template('profile.html', user=user, error=error)
    
    else:
        return redirect(url_for("profile"))


@app.route('/logout')
def logout():
    session.pop("user", None)
    return render_template('index.html')


@app.route('/schedule')
def schedule():
    if "user" in session:
        user = session["user"]

    return render_template('planmeal.php', user=user)



app.add_url_rule(
    '/graphql',
    view_func=GraphQLView.as_view(
        'graphql',
        schema=schema,
        graphiql=True  # for having the GraphiQL interface
    )
)

if __name__ == '__main__':
    app.run(debug=True)
