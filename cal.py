from flask import Flask, request, render_template, redirect
from flask_sqlalchemy import SQLAlchemy

app = Flask(__name__)
app.static_folder = 'static'

app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/cal'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
db = SQLAlchemy(app)


class Event(db.Model):

    __tablename__ = 'event'

    ename = db.Column(db.String(255), primary_key=True)
    stime = db.Column(db.DateTime)
    etime = db.Column(db.DateTime)

    def __init__(self, ename, stime, etime):
            self.ename = ename
            self.stime = stime
            self.etime = etime


    def __repr__(self):
            return '<date %r>' % self.date

@app.route('/', methods=['POST','GET'])
def index():
    if request.method=="POST":
        ename = request.form['ename']
        stime = request.form['stime']
        etime = request.form['etime']
        
        new_event = Event(ename, stime, etime)

        try:
            db.session.add(new_event)
            db.session.commit()
            return redirect('/')
        except:
            return "Error"
        # pass
    else:
        events = Event.query.all()
        return render_template('index.html', events=events)
        # return render_template('index.html')

if __name__ == '__main__':
    app.run(debug=True,port=5000)