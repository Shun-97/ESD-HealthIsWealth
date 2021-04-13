FROM python:3-slim
WORKDIR /usr/src/getRecipe
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt 
COPY ./getRecipe.py ./AMQP_setup.py ./
CMD ["python","./getRecipe.py"]