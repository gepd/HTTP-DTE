FROM node:12.13.1-alpine

WORKDIR /home/node/dte

COPY ./package*.json ./yarn.lock ./

RUN apk update && apk add yarn

RUN yarn install

COPY . .

CMD ["yarn", "start"]