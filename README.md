FlowHubBlink
============

A small specialized tool that allows you to visualize the number of assigned GitHub pull-requests and unread messages in Flowdock via blink(1).

One LED is used to show the flowdock status. If you have any unread messages in flowdock this LED will turn orange. (As the small orange dots in the flowdock UI)

The other LED is used to show the number of assigned pull-requests. This is green for zero pull-requests, blue for 1-3 pull-requests, orange for 4-6 pull-requests and red for more than 6 pull-requests.
Currently this is hardcoded, in the future this may be configurable (see Roadmap).

This is currently work in progress, but it at least works in its current state.

Requirements
------------
Since this is written in PHP you need it to execute the tool.
Of course you also need a blink(1), and the blinkControl software.


Usage
-----
1. Start the blinkControl software, enable the "API server"
2. Download the repo, copy `flowhubblink.conf.example` to flowhubblink.conf and adjust it to your needs.
3. Run `composer install` to install required dependencies.
4. Run update.php (via `php update.php`) to update the lights of your blink(1).



Roadmap
-------
- Implement a continuously running daemon that updates the blink(1) and also flashes it if the counts change. This allows you
to see if something changes.
- Make it more configurable
- More secure GitHub authentication (no more entering passwords into the config file)