import "./bootstrap";

const id = getID;
const channel = Echo.private(`message-channel-${id}`);

channel.subscribed(() => {
    console.log('listening');
})
.listen('.SendMessage',(ev)=>{
    console.log(ev)
})
