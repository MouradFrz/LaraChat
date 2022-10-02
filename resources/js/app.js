import './bootstrap';


const channel = Echo.channel('public-test-channel');

Echo.channel('chat-room')
.subscribed(()=>{})
.listen('.ChatMessage',(ev)=>{
    let myPP = document.createElement('p')
    myPP.innerText=ev.message
    document.querySelector('form').append(myPP)
    console.log(ev)
})


// channel.subscribed(()=>{
//     console.log('subbed to test channectyjl')
// }).listen('.My Testing Event',(payload)=>{
//     console.log(payload)
// })