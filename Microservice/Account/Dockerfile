FROM python:3-buster
WORKDIR /usr/src/account
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt
COPY ./account.py ./AMQP_setup.py ./
CMD [ "python", "./account.py" ]
