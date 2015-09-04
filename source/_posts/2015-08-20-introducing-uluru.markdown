---
layout: post
title: "Introducing Uluru"
date: 2015-08-20 15:46:16 -0500
comments: true
categories: hack, programming
---


---
layout: post
title: Browser Telemetry and U(luru)
author: Christopher Agocs
---

*tl;dr* We can now tell how much time our clients spend waiting for Backstop to load.


One of the biggest questions the Speed team is faced with is "What's slow?" We don't know, but we can absolutely find out. 

We chose to define slowness as "people waiting for our website to be usable", because we can absolutely measure that. Uluru is the system we put together that records telemetry from the client's browser and reports it back to Backstop for analysis.

Design goals
------------

There exist other solutions, commercial and open source, for recording and reporting on browser telemetry. It was found, however, that these solutions were significantly complex, and in many cases interfered with JavaScript we were already using, causing JavaScript errors and preventing the browser from rendering UI elements. Therefore, the design goals of Uluru became:

- Minimalism: Uluru.js is 38 lines of whitespace-heavy JavaScript. It should be extremely readable.
- Light weight: When minified, Uluru.js squishes down under 400 bytes.
- Speed: Uluru.js has no dependencies on other JS libraries. 
- No hacks: Uluru.js makes a single POST request to a remote server. It does not e.g. cram metrics into query parameters and make a series of requests GETting hidden images or iframes.

Implementation
--------------

### Client side ###

Uluru is a function that, when called, gets the time since navigation started and some other metrics, and sends those to an endpoint. We've set it up such that `uluru(endpoint)` is called when `window.onload` fires, under the assumption that most of our product is useful by that point.

Uluru collects the following data:

- url: the `window.location.href`
- connectionTime: the time (ms since UNIX epoch) the connection was initiated.
- connectionDelta: the time spent establishing a connection to the server
- firstByte: the time spent waiting for the server to respond with the first byte of data
- responseDelta: the time the server spent sending a response to the client
- loadTime: time between the `navigationStart` and `window.onload` events.

### Server side ###

We've created an `UluruResource` REST endpoint. It accepts POST requests to `/backstop/rest/uluru`, and logs the data POSTed to it to Splunk. It currently expects the above data, but could be genericised to accept any JSON object that represents a `Map<String><String>`.

### Usage ###

Currently, the Uluru script is loaded in `all-js.jsp`. It is wrapped in code that tests the `browser.telemetry.disabled` config datum, and a check to see if the user is logged in. Then, we add the following two script elements:

        <script type="text/javascript" src="${bs:cdn('/backstop/static/js/bsg/uluru.js')}" ></script>
        <script type="text/javascript">
            window.onload = function(){ uluru("/backstop/rest/uluru/");};
        </script>

Data
----

Uluru has been in beta for a day, and already the juicy juicy data is flowing. I made a first pass at a [Beta Browser Telemetry Dashboard][dashboard]. 

I have other ideas for reports we can generate, such as one that shows the time we've save clients between last month and this month. That can be translated (roughly) to dollars we've save the client. 

Further directions
------------------

Currently, Uluru is all about browser telemetry being reported to Splunk via Fundbutter REST endpoints. In the future, I'd love to see a generic Uluru server (or cluster) capable of receiving generic metrics from various sources, and capable of reporting those to many places.




[dashboard]: https://splunk.backstopsolutions/en-US/app/search/beta_client_performance?earliest=0&latest=
