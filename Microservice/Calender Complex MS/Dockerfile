FROM python:3-slim
WORKDIR /usr/src/calendar_complexMS
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt 
COPY ./Calender.py .
CMD ["python","./Calender.py"]