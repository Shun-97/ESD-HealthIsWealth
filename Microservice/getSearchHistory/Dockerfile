FROM python:3-slim
WORKDIR /usr/src/getSearchHistory
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt 
COPY ./getSearchHistory.py ./
CMD ["python","./getSearchHistory.py"]