<!DOCTYPE html>
	<html>
		<head></head>
		<body>
			<div id='test'>0</div>
			<div id='msg'></div>
			<script>
				
			//periodic call:
			// !!! DECLARE WITHOUT "()"
			//it has to be declared object in order to stop the call, otherwise you can't call stop()
			function _periodic_call(_called_function, _times_per_second){
				if (_times_per_second==undefined || _times_per_second==0) {_times_per_second=1}
				this._times_per_second=_times_per_second
				this._called_function=_called_function
				this._start=function(){this._intervalID=setInterval(this._called_function, 1000/this._times_per_second);}
				this._stop=function(){clearInterval(this._intervalID)}
			}			
			
			//delayed call
			function _delayed_call(_called_function, _seconds){
				if (_seconds==undefined || _seconds==0){_seconds=1}//sanity
				this._called_function=_called_function;
				this._seconds=_seconds;
				this._premature=function(){}
				this._stop=function (){clearInterval(this._intervalID);this._intervalID=undefined;}
				this._2call=function(){clearInterval(this._intervalID);this._intervalID=undefined;this._called_function()}.bind(this)
				this._start=function(){
					if (this._intervalID!=undefined) {
						clearInterval(this._intervalID);
						this._intervalID=undefined;
						this._premature();
						}
					this._intervalID=setInterval(this._2call, 1000*_seconds);
				}
			}			
				
			var msg=function(){
				var test_el=document.getElementById('test')
				var msg_el=document.getElementById('msg')
				test_el.innerHTML=parseInt(test_el.innerHTML)+1
				msg_el.innerHTML='The DID is DONE, sir';
			}
			
			var dc=new _delayed_call(msg,2)
			dc._premature=function(){
				var msg_el=document.getElementById('msg');
				msg_el.innerHTML='Are you in a hurry? Now you\'ll have to wait some more!';
			}
			
			window.onclick=function(){
				var msg_el=document.getElementById('msg');
				msg_el.innerHTML='Wait for it ...';
				dc._start();
				}
			var msg_el=document.getElementById('msg');
			msg_el.innerHTML='Click on the window for a delayed increment. Multi-click if you are in a hurry :)';				
			</script>
		</body>
	</html>























