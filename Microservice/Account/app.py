from flask import Flask, request, render_template, redirect, url_for, session, jsonify
from flask_sqlalchemy import SQLAlchemy
import graphene
from graphene_sqlalchemy import SQLAlchemyObjectType, SQLAlchemyConnectionField
from flask_graphql import GraphQLView
from datetime import timedelta
from flask_cors import CORS


app = Flask(__name__)
cors = CORS(app, resources={r"/api/*": {"origins": "*"}})

# For login session
app.secret_key = "healthiswealth"
app.permanent_session_lifetime = timedelta(minutes=30)
# Database connection
app.config['SQLALCHEMY_DATABASE_URI'] = 'postgresql://qepnpscgacacmr:d338fb6ef24db3eed89c7a4200ac74e8cb5c1ffd22bf8e26194eb684c6b8e33d@ec2-52-21-252-142.compute-1.amazonaws.com:5432/ddo160cbfi69qt'
app.config['SQLALCHEMY_COMMIT_ON_TEARDOWN'] = True
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = True
db = SQLAlchemy(app)


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
    userAccount_by_username = graphene.List(
        UserAccountObject, username=graphene.String())

    @staticmethod
    def resolve_registration_by_username(parent, info, **args):
        q = args.get('username')

        registration_query = RegistrationObject.get_query(info)

        return registration_query.filter(Registration.Username == q).all()

    def resolve_userAccount_by_username(parent, info, **args):
        q = args.get('username')

        userAccount_query = UserAccountObject.get_query(info)

        return userAccount_query.filter(UserAccount.Username == q).all()

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


class updateUserAccount(graphene.Mutation):
    class Arguments:
        Username = graphene.String(required=True)
        Weight = graphene.Float(required=False)
        Height = graphene.Float(required=False)
        BMI = graphene.Float(required=False)

    userAccount = graphene.Field(UserAccountObject)

    def mutate(self, info, Username, Weight, Height, BMI):
        userAccount = db.session.query(
            UserAccount).filter_by(Username=Username).first()
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


@app.route('/api/login/verification', methods=['POST'])
def login():
    if request.method == 'POST':
        jsondata = request.get_json(force=True)
        # return request.form
        username = jsondata['username']
        password = jsondata['password']

        schema = graphene.Schema(query=Query)
        query_string = '{registrationByUsername(username:"' + \
            username + '"){Username Password Email}}'
        validate = schema.execute(query_string)
        # print(validate)
        # Check if user exist
        if not validate.data['registrationByUsername']:
            # return {"message": "user don't exist"}

            return {
                "code": 500,
                "data": {
                    "message": 'Users do not exist'
                }}

            # Check if password matches
        elif validate.data['registrationByUsername'][0]['Password'] == password:
            return {
                "code": 201,
                "data": {
                    "username": username,
                    "registration": validate.data['registrationByUsername']
                }}

        else:
            return {
                "code": 500,
                "data": {
                    "message": 'Wrong Password'
                }}
            # return {"message": "user don't exist"}
    elif request.is_json:
        try:
            google = request.get_json()
            print("Received")
            username = google["username"]
            password = google["password"]

            schema = graphene.Schema(query=Query)
            query_string = '{registrationByUsername(username:"' + \
                username + '"){Username Password Email}}'
            validate = schema.execute(query_string)

            # Check if user exist
            if not validate.data['registrationByUsername']:
                return {
                    "code": 500,
                    "data": {
                        "message": 'Users do not exist'
                    }}

            # Check if password matches
            elif validate.data['registrationByUsername'][0]['Password'] == password:
                session.permanent = True
                session["user"] = username
                return {
                    "code": 201,
                    "data": {
                        "username": username,
                        "registration": validate.data['registrationByUsername']
                    }}

            else:
                return {
                    "code": 500,
                    "data": {
                        "message": 'Wrong Password'
                    }}

            return jsonify(google)

        except Exception as e:
            # Unexpected error in code
            exc_type, exc_obj, exc_tb = sys.exc_info()
            fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
            ex_str = str(e) + " at " + str(exc_type) + ": " + \
                fname + ": line " + str(exc_tb.tb_lineno)
            print(ex_str)

            return jsonify({
                "code": 500,
                "message": "internal error: " + ex_str
            }), 500


@app.route('/api/register/verification', methods=['POST'])
def register():
    if request.is_json:
        try:
            # Grab the data
            google = request.get_json()
            print("Received")
            # Map the data
            username = google["username"]
            email = google["email"]
            password = google["password"]

            # Create_registration will return a tuple. e.g. (True, graphql return dict data) or (False, error message)
            create = create_registration(username, email, password)

            # If True (success)
            if create[0]:
                return {
                    "code": 201,
                    "data": {
                        "username": username,
                        "registration": create[1]
                    }}

            else:
                error = "Failed to create account. Please try again"
                return {
                    "code": 500,
                    "data": error
                }

        # This part... I copied from prof's codes, I think it returns an error message if the try doesn't work
        except Exception as e:
            # Unexpected error in code
            exc_type, exc_obj, exc_tb = sys.exc_info()
            fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
            ex_str = str(e) + " at " + str(exc_type) + ": " + \
                fname + ": line " + str(exc_tb.tb_lineno)
            print(ex_str)

            return jsonify({
                "code": 500,
                "message": "internal error: " + ex_str
            }), 500

    # For ownself registration
    elif request.method == 'POST':
        # Grabbing data from the form
        username = request.form['username'].lower()
        email = request.form['email']
        password = request.form['password']

        # Create_registration will return a tuple. e.g. (True, graphql return dict data) or (False, error message)
        create = create_registration(username, email, password)

        # If True (success)
        if create[0]:

            return {
                "code": 201,
                "username": username,
            }

        else:
            return {
                "code": 500,
                "message": "Failed to create account. Please try again"
            }

    else:
        return {
            "code": 500,
            "message": "Failed to create account. Please try again"
        }


def create_registration(username, email, password):
    schema = graphene.Schema(query=Query, mutation=Mutation)
    # Check if username already exist in the database
    exist = username_exist(username)

    # Check if user exist
    if exist[0]:
        return (False, exist[1])  # error msg

    else:
        # Query
        create_registration = 'mutation{createRegistration(Email:"'+email+'", Username:"' + \
            username+'",Password:"'+password + \
            '"){registration{Email Username Password}}}'
        create_userAccount = 'mutation{createUseraccount(Username:"' + \
            username+'"){userAccount{Username}}}'

        # Execute
        register = schema.execute(create_registration)
        userAccount = schema.execute(create_userAccount)
        return (True, register.data["createRegistration"])

# Checks the database if the username exsit


def username_exist(username):
    schema = graphene.Schema(query=Query, mutation=Mutation)
    # Qeury
    query_string = '{registrationByUsername(username:"' + \
        username + '"){Username Password Email}}'
    # Execute
    validate = schema.execute(query_string)

    # If there's data in registrationByUsername, give error
    if validate.data['registrationByUsername']:
        error = "user exist, Please login instead"
        return (True, error)
    else:
        return (False, validate.data['registrationByUsername'])


app.add_url_rule(
    '/graphql',
    view_func=GraphQLView.as_view(
        'graphql',
        schema=schema,
        graphiql=True  # for having the GraphiQL interface
    )
)


if __name__ == '__main__':
    app.run(port=5100, debug=True)
