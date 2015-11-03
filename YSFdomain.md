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

### Network Controller

* Authoratative DNS server
* Data Access / REST services
* Repeater and Callsign Roaming Database
* Reflector Room Directory

The network controller(s) can be found by the client using DNS. These have the authoritative DNS servers for the network, and a set of HTTP REST services for registering Access Points (repeaters, nodes), getting the Reflector Room Directory and so on.

DNS Lookup of _ysfctrl._tcp.<domain> will give one or more SRV records that point the client to the HTTP REST endpoints.

Using its callsign, the client regularly registers as "available" using the correct REST endpoint, and is thereby marked as such in the repeater database.

DNS Lookup of CALLSIGN._ap.<domain> will give  A records to provide the information neccessary to contact client "CALLSIGN" directly.

### Client

The client is a software component in the Access Point Controller (Repeater or Node).
(It is also possible that the client is a special "system bridge" that is acting on behalf of a user when translating between CCS or DMR and YSFdomain.)

The client only need to have the correct domain name configured.
By making DNS lookups under the configured domain, clients can get all the rest of the information needed to participate in the network. This should give the network administrators the flexibility to change configurations as they see fit without involving all the users.

### Reflector

* Multiple rooms (data stream distributors)

### Issues

* Authentication
* Streaming Protocol for communication. UDP? SCTP? (over UDP?) 
* Specify details of REST endpoints
* Repeater callsign naming conventions? (Node and User with same callsign problem)
