FROM python:3-slim
WORKDIR /usr/src/caloriesMS
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt 
COPY ./calories.py .
CMD ["python","./calories.py"]