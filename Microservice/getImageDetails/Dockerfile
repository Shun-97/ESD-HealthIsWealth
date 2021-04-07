FROM node:12.18.1
ENV NODE_ENV=production

WORKDIR /user/src/imageDet

COPY ["package.json", "package-lock.json*", "./"]

RUN npm install --production

COPY . .

EXPOSE 6000

CMD [ "node", "server.js" ]