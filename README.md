
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
Just enter:

>make it

It will build the project then run the server.

Routes
--
>(**POST**) /player/play 
>
>Returns the player's most optimal play.
>
>*Parameters:* 
> - **playerHand** (integer array) : the player hand
> - **dealerHand** (integer array) : the dealer hand
> - **remainingCards** (integer array): the remaining cards in the deck
>
> Returns a string which is either **hit**, **stand**, **double** or **split**.
>

>(**POST**) /dealer/bust 
>
>Calculates the probability that the dealer will bust with a given hand and deck.
>
>*Parameters:* 
> - **hand** (integer array) : the dealer hand
> - **remainingCards** (integer array): the remaining cards in the deck
>
> Returns a float between 0 and 1.
