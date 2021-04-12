FROM python:3-slim
WORKDIR /usr/src/getExercise
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt 
COPY ./getExercise.py ./AMQP_setup.py ./
CMD ["python","./getExercise.py"]
