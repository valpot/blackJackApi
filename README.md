
<p align="center"><a href="https://symfony.com" target="_blank">
    <img 
    src="https://image.flaticon.com/icons/svg/1983/1983632.svg" 
    width="350">
</a></p>

BlackJack API
==

This API helps you when playing blackjack, it calculates win probability, dealer busting odds and so on...
 
Installation
--
docker-compose setup:

>docker-compose up -d --build

It will build the Docker image then run the server trough docker-compose.
You can then browse localhost:2121 ;)

Tips
--

In order to display all logs

>docker-compose logs -f 

In order to display only logs from a specific container

>docker-compose logs php

>docker-compose logs nginx

In order to exec command inside a container and do task like composer install

>docker-compose exec php sh

Routes
--

>(**POST**) /dealer/bust 
>
>Calculates the probability that the dealer will bust with a given hand and deck.
>
>*Parameters:* 
> - **hand** (integer array) : the dealer hand
> - **remainingCards** (integer array): the remaining cards in the deck
>
> Returns a float between 0 and 1.
