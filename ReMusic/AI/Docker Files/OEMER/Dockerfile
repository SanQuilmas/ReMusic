FROM python:3

WORKDIR /usr/src/app

COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt

COPY TEST_IMAGES/test.png ./TEST_IMAGES

COPY . .

CMD [ "cd TEST_IMAGES", "oemer test.png", "ls" ]