FROM python:3-buster
WORKDIR /usr/src/account
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt
COPY ./accountManagement.py ./AMQP_setup.py ./
CMD [ "python", "./accountManagement.py" ]
