FROM python:3-slim
WORKDIR /usr/src/recipe
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt 
COPY ./recipe.py .
CMD ["python","./recipe.py"]