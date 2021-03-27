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

    registration_by_username = graphene.List(
        RegistrationObject, username=graphene.String())

    @staticmethod
    def resolve_registration_by_username(parent, info, **args):
        q = args.get('username')

        registration_query = RegistrationObject.get_query(info)

        return registration_query.filter(Registration.Username == q).all()

# Graphql Mutation


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


class Mutation(graphene.ObjectType):
    create_registration = CreateRegistration.Field()
    create_userAccount = CreateUserAccount.Field()


schema = graphene.Schema(query=Query, mutation=Mutation)

# Routes
@app.route('/')
def index():
    return render_template('index.html')


@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        username = request.form['username']
        password = request.form['password']

        schema = graphene.Schema(query=Query)
        query_string = '{registrationByUsername(username:"' + \
            username + '"){Username Password Email}}'
        validate = schema.execute(query_string)

        # Check if user exist
        if not validate.data['registrationByUsername']:
            error = "user don't exist"
            return render_template('login.html', error=error)

        # Check if password matches
        elif validate.data['registrationByUsername'][0]['Password'] == password:
            session.permanent = True
            session["user"] = username
            return redirect(url_for("profile"))

        else:
            error = "Wrong password"
            return render_template('login.html', error=error)

        return render_template('login.html')

    else:
        return render_template('login.html')


@app.route('/register', methods=['GET', 'POST'])
def register():
    if request.method == 'POST':
        username = request.form['username']
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
            mutation_string = 'mutation{createRegistration(Email:"'+email+'", Username:"' + \
                username+'",Password:"'+password + \
                '"){registration{Email Username Password}}}'
            register = schema.execute(mutation_string)
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

        return render_template('profile.html', user=user)
    else:
        return render_template('index.html')


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
