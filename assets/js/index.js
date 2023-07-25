const useState = function(initial){
  let nowData = {
      value: initial,
  }
  let listeners = [];
  let get = function(){
      return nowData.value;
  }
  let set = function(val){
      if(nowData.value !== val){
          emitOnChange(nowData.value, val);
          nowData.value = val;
      }
  }
  let on = function(callback){
      if(typeof callback === "function")
          listeners.push(callback)
      else
          throw "Callback Parameter is not a function";
  }
  let emitOnChange = function(newVal, oldVal){
      listeners.forEach((listener) => {
          listener(newVal, oldVal);
      });
  }
  return [get, set, on];
};
let [getNavOpen, setNavOpen, onNavChange] = useState(true);
onNavChange((newVal)=>{
  if(newVal){
      document.getElementById('nav_menu').classList.remove('hidden');
      document.getElementById('nav_menu').classList.add('block')
      document.getElementById('nav_toggle').classList.add('show-toggle')
  } else {
      document.getElementById('nav_menu').classList.add('hidden');
      document.getElementById('nav_menu').classList.remove('block');
      document.getElementById('nav_toggle').classList.remove('show-toggle')
  }
})
