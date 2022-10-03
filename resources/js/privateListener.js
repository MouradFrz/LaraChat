import "./bootstrap";
const myEmail = email;
const id = getID;
const channel = Echo.private(`message-channel-${id}`);
const wrapper = document.querySelector('.messages-wrapper')
channel.subscribed(() => {
})
.listen('.SendMessage',(ev)=>{
    let el = document.createElement('div')
    el.classList.add('message')
    if(ev.sender !== myEmail){
        el.classList.add('sent')
    }
    el.innerHTML=`<p>${ev.message}</p>`
    document.querySelector('.messages-wrapper').append(el)
    wrapper.scrollTop = wrapper.scrollHeight;
    document.querySelector('.input-field').value = ''
})
