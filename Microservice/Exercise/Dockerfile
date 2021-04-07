FROM python:3-slim
WORKDIR /usr/src/exercise
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt 
COPY ./exercise.py .
CMD ["python","./exercise.py"]
