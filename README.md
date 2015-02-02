FlowHubBlink
============

A small specialized tool that allows you to visualize the number of assigned GitHub pull-requests and unread messages in Flowdock via blink(1).

This is currently work in progress, but it at least works in its current state.

Requirements
------------
Since this is written in PHP you need it to execute the tool.
Of course you also need a blink(1), and the blinkControl software.


Usage
-----
Download the repo, copy `flowhubblink.conf.example` to flowhubblink.conf and adjust it to your needs.
Run the blinkControl software, enable the "API server" and then run update.php (via `php update.php`) to update the lights of your blink(1).



Roadmap
-------
- Implement a continuously running daemon that updates the blink(1) and also flashes it if the counts change. This allows you
to see if something changes.
- Make it more configurable
- More secure GitHub authentication (no more entering passwords into the config file)