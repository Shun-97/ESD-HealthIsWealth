FROM python:3-slim
WORKDIR /usr/src/planning
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt 
COPY ./Calories.py .
CMD ["python","./Calories.py"]