# YSFdomain System Specification

Draft 20151103

License: CC BY-SA 4.0

Authors:
* LA1FTA Morten Johansen

## Purpose

An open network specification for digitally linking Yaesu System Fusion repeaters and simplex access points.

The aim is to create a specification that scales from a simple one-server installation to a global network instance with fault tolerance capabilities.

## Overview

The basic idea is to use DNS as a database for all the lookups the system needs. Each deployment of this specification will reside under one domain name, and can be seen as a YSFdomain network instance. The network consists of one or more Network Controllers, Clients and one or more Reflector servers.

In this specification, the domain name `example.com` is used throughout.

### Network Controller

* Authoratative DNS server
* Data Access / REST services
* Repeater and Callsign Roaming Database
* Reflector Room Directory

The network controller(s) can be found by the client using DNS. These have the authoritative DNS servers for the network, and a set of HTTP REST services for registering Access Points (repeaters, nodes), getting the Reflector Room Directory and so on.

DNS Lookup of `_ctrl.example.com` will give one or more SRV records that point the client to the HTTP REST endpoints.

Using its callsign, the client regularly registers as "available" using the correct REST endpoint, and is thereby marked as such in the repeater database.

DNS Lookup of `APCALLSIGN._ap.example.com` will give an A record with the IP address to contact client "APCALLSIGN" directly.

### Client

The client is a software component in the Access Point Controller (Repeater or Node).
(It is also possible that the client is a special "system bridge" that is acting on behalf of a user when translating between CCS or DMR and YSFdomain.)

The client only need to have the correct domain name configured.
By making DNS lookups under the configured domain, clients can get all the rest of the information needed to participate in the network. This should give the network administrators the flexibility to change configurations as they see fit without involving all the users.

When the Access Point receives RF traffic from a user, the Client reports the user's callsign to the Network Controller on the appropriate REST endpoint. The user is thereby registered as available on this Access Point in the roaming database.

When a specific user needs to be contacted, DNS lookup of `USERCALLSIGN._user.example.com` gives the client an SRV record with the neccessary info to contact the user.

The client can also use DMR number to lookup a callsign, in case the user requested it via DTMF. DNS lookup of `DMRID._dmrid.example.com` gives the client an SRV record with the neccessary info to contact the user.

### Reflector

A reflector is basically a client type that resides in a data center. It has the ability to distribute the bitstream from one client to the other connected clients.

It might also distribute a bitstream from other sources. Audio, Messages, Images?

DNS lookup of `ROOMID._room.example.com` gives the client an SRV record with the neccessary info to contact the reflector/room.

* Multiple rooms (data stream distributors)

### Issues

* Numerous details that need to ble further clarified
* See others on Github master

