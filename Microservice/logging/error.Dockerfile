FROM python:3-slim
WORKDIR /usr/src/logging
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt 
COPY ./error.py ./AMQP_setup.py ./
CMD ["python","./error.py"]