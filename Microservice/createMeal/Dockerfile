FROM python:3-slim
WORKDIR /usr/src/createMeal
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt 
COPY ./createMeal.py ./AMQP_setup.py ./
CMD ["python","./createMeal.py"]