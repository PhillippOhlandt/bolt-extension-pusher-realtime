Pusher Extension for Bolt
======================

This [bolt.cm](https://bolt.cm/) extension enables realtime functionality through [Pusher](https://pusher.com) on your website. 


### Requirements
- Bolt 3.x installation
- [pusher.com](https://pusher.com) account

### Installation
1. Login to your Bolt installation
2. Go to "Extend" or "Extras > Extend"
3. Type `pusher-realtime` into the input field
4. Click on the extension name
5. Click on "Browse Versions"
6. Click on "Install This Version" on the latest stable version

### Configuration
1. Open the extension config file ('/app/config/extensions/pusherrealtime.ohlandt.yml' or Extend -> "Config" button on the extension entry)
2. Fill in your Pusher keys and ids. (important: whitespace between colon and value)
3. Decide which events on which contenttypes you want to push

### Enable and configure Pusher in your theme
Paste the following into the HEAD section of your HTML.

```
{{ enable_pusher() }}
```

This will render the following HTML in your theme to enable and setup the Pusher client library.

```
<script src="//js.pusher.com/3.1/pusher.min.js"></script>
<script>
    var pusherKey = "YOUR-PUSHER-KEY";
    var pusher = new Pusher(pusherKey, {encrypted: true});
</script>
``` 

##### Listen on events
Currently this events will be pushed based on your configuration.

- Channel `{name of the contenttype}`
	- Event `created`: Record was created
	- Event `updated`: Record was updated
	- Event `deleted`: Record was deleted

For this example, we listen on the `created` event on the `entries` channel and log the data to the console.

```
<script>
	var entries = pusher.subscribe('entries');
	entries.bind('created', function(data) {
		console.log(data);
	});
</script>
```

The data will look like this.

```
{
  "id": "1",
  "contenttype": "entries",
  "record": {
    MUCH DATA HERE
  }
}
```


For more information on how to use the Pusher client library, look [here](https://github.com/pusher/pusher-js).

### Twig Functions

`enable_pusher()` - Returns all the JS needed to set up Pusher in the frontend. (See above)

`pusher_key()` - Returns the public key needed to create a new Pusher instance in the frontend.

---

### License

This Bolt extension is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)