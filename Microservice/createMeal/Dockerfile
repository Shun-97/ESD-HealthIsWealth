FROM python:3-slim
WORKDIR /usr/src/meal
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt 
COPY ./createMeal.py .
CMD ["python","./createMeal.py"]