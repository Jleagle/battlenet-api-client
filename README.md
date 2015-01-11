battlenet-api-client
====================

A package to retrieve information from the Battle.net API (https://dev.battle.net/)

###### Pros
- Code hinting (in progress)
- Contains all game APIs (Diablo 3, StarCraft 2 and WoW) 

###### Cons
- Does not contain account related end points

### Usage

Instantiate the package using your games class, passing though your API key, ServerLocation and ResponseLocale:

```php
$warcraft = new Warcraft(
  $key,
  ServerLocations::EU,
  ResponseLocales::EN_GB
);
```

Example API calls:

```php
// Retrieve auction data
$auctions = $warcraft->getAuctions('outland');

// Retrieve realm list
$realms = $warcraft->getRealms();

// Retrieve achievement details
$achievement = $warcraft->getAchievement(2144);
```
