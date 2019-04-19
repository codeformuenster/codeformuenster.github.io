FROM python:3-alpine

COPY requirements.txt ./
RUN  pip install --no-cache-dir -r requirements.txt

COPY src/ /app
WORKDIR /app
CMD [ "python", "update-members.py" ]
