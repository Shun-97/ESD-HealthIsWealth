FROM python:3-slim
WORKDIR /usr/src/getMeals
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt 
COPY ./getMeals.py ./AMQP_setup.py ./
CMD ["python","./getMeals.py"]