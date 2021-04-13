FROM python:3-slim
WORKDIR /usr/src/getMealHistory
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt 
COPY ./getMealHistory.py ./
CMD ["python","./getMealHistory.py"]