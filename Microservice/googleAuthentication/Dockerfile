FROM python:3-buster
WORKDIR /usr/src/googleAuthentication
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt 
COPY ./googleAuthentication.py ./AMQP_setup.py ./
CMD ["python","./googleAuthentication.py"]