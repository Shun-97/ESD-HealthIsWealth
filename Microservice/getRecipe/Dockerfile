FROM python:3-slim
WORKDIR /usr/src/recipe_complex
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt 
COPY ./getRecipe.py .
CMD ["python","./getRecipe.py"]