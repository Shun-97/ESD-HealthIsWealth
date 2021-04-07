FROM python:3-buster
WORKDIR /usr/src/google
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt 
COPY ./google_auth.py .
CMD ["python","./google_auth.py"]