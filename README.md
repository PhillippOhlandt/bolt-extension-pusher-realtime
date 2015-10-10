Pusher Extension for Bolt
======================


This [bolt.cm](https://bolt.cm/) extension enables realtime functionality through [Pusher](https://pusher.com) on your website. 

-

### Requirements
- Bolt 2.x installation
- [pusher.com](https://pusher.com) account

### Installation
1. Login to your Bolt installation
2. Go to "View/Install Extensions" (Hover over "Extras" menu item)
3. Type `pusher-realtime` into the input field
4. Click on the extension name
5. Click on "Browse Versions"
6. Click on "Install This Version	" on the latest stable version

### Configuration
1. Go to "Configure Extensions" (Hover over "Extras" menu item)
2. Click on "pusher-realtime.ohlandt.yml"
3. Fill in your Pusher keys and ids. (important: whitespace between colon and value)
4. Decide which events you want to push

### Enable and configure Pusher in your theme
Paste the following into the HEAD section of your HTML.

```
{{ enablePusher() }}
```

This will render the following HTML in your theme to enable and setup the Pusher client library.

```
<script src="https://js.pusher.com/3.0/pusher.min.js"></script>
<script>
	var pusherKey = "YOUR-PUSHER-KEY";
	var pusher = new Pusher(pusherKey, {encrypted: true});
</script>
``` 

##### Listen on events
Currently the this events will be pushed based on your configuration.

- Channel `records`
	- Event `created`: Record was created
	- Event `updated`: Record was updated
	- Event `deleted`: Record was deleted

For this example, we listen on the `created` event on the `records` channel and log the data to the console.

```
<script>
	var records = pusher.subscribe('records');
	records.bind('created', function(data) {
		console.log(data);
	});
</script>
```

The data will look like this.

```
{
  "id": "1",
  "contenttype": "posts",
  "record": {
    MANY DATA HERE
  }
}
```

For more informations on how to use the Pusher client library, look [here](https://github.com/pusher/pusher-js)

##### Notes on Record Deleted event
This event contains only the record ID and minimal record data. There is currently no way to get the contenttype of the record. Look [here](https://github.com/bolt/bolt/issues/4248) for more informations about this bug.

---

### License

Thos Bolt extension is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)