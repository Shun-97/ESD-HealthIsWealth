FROM python:3-slim
WORKDIR /usr/src/planExerciseSchedule
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt 
COPY ./planExerciseSchedule.py ./AMQP_setup.py ./
CMD ["python","./planExerciseSchedule.py"]