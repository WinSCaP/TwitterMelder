# TwitterMelder
Hoe meld SchipholHerrie semi-geautomatiseerd naar Twitter
>Een beetje mag wel, maar het is niet de bedoeling dat Schiphol je slaapritme bepaald.

## Benodigdheden
*NB: Dit is mijn setup, wil je jouw setup delen, neem contact op via Twitter*

* Docker met HomeAssistant + MQTT + NodeRed (NodeRed Flow onder aan deze README)
* NodeRed Plugins:
  * node-red-contrib-flightradar24
  * node-red-contrib-web-worldmap (Het kan zonder, maar is fijn voor debuggen)
  * node-red-node-geofence
  * node-red-node-twitter
* Een knop (Zigbee?)

## TODO/Wensen:
* Automatisch melden bij BAS en VliegHerrie
* Plaatje met vluchtpad
* dB meter bouwen [DMNS](https://sensor.community/en/sensors/dnms/) en koppelen

## NodeRed Flow
[Download deze flow](nodered-flow.json)

![Flow](nodered-flow.png)
