# AdminPanel
<p align="center">
<img src="https://api.codacy.com/project/badge/Grade/6329b086389946eeb2dc4a792d2eb50e"/>
<img src="https://scrutinizer-ci.com/g/Jason2605/AdminPanel/badges/quality-score.png?b=master" alt="Build Status">
<img src="https://scrutinizer-ci.com/g/Jason2605/AdminPanel/badges/build.png?b=master" alt="Build Status">
<img src="https://codeclimate.com/github/Jason2605/AdminPanel/badges/gpa.svg" />
       <a href="https://discord.gg/kZCTRPk">
        <img src="https://img.shields.io/badge/Discord-Join%20chat%20→-738bd7.svg" alt="Join the chat at https://discord.gg/kZCTRPk">
       </a>
</p>

## AdminPanel API Info

<p>AdminPanel now has a brand new API available to be used, 
it returns the data in json so many languages can use it for various things.

The panel currently has 12 functions which you can use at this moment in time.
</p>


* all - This returns info about every player in your database and things such as total amount of money, and player count.
* search - This allows you to get information about a certain player(use the players id ex.76561198035548503).
* money - Returns amount of money through out the entire server.
* players - Returns the amount of players in the database.
* wanted - Returns the players wanted and what they are wanted for.
* vehicles - Returns the amount of vehicles in the database.
* coplevel - Returns a list of all the players with the highest cop level first.
* mediclevel - Returns a list of all the players with the highest medic level first.
* donorlevel - Returns a list of all the players with the highest donor level first.
* adminlevel - Returns a list of all the players with the highest admin level first.
* gangs - Returns the information about all the gangs on the server.
* richlist - Returns a default of the richest 10 players (ordered by bank), you can add the optional 'limit' to the url to change the number of players returned

<p>The API was made to help out people who are using things such as IPS where you dont want to add 
queries etc into the code itself so instead you can just use the API to simply get the data instead. 
However it can be used for various other things such as discord bots and more.</p>

Examples

* http://139.59.163.114/Other/Admin/AdminPanel_V2/API/api.php?user=test&pass=test&request=all
* http://139.59.163.114/Other/Admin/AdminPanel_V2/API/api.php?user=test&pass=test&request=richlist
* http://139.59.163.114/Other/Admin/AdminPanel_V2/API/api.php?user=test&pass=test&request=richlist&limit=2
* http://139.59.163.114/Other/Admin/AdminPanel_V2/API/apiExample.php
