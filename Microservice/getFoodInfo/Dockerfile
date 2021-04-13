FROM python:3-slim
WORKDIR /usr/src/getFoodInfo
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt 
COPY ./getFoodInfo.py ./AMQP_setup.py ./
CMD ["python","./getFoodInfo.py"]