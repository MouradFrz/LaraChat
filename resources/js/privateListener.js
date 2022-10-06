import "./bootstrap";
const myEmail = email;
const id = getID;
const channel = Echo.private(`message-channel-${id}`);
const wrapper = document.querySelector(".messages-wrapper");
const input = document.querySelector(".input-field");
let timeout = false;
const talkingTo =
        document.querySelector("#convo-with").textContent + "@gmail.com";
const circle = document.querySelector('.circle')
const status = document.querySelector('.status')

channel
    .listen(".SendMessage", (ev) => {
        setOnline()
        let el = document.createElement("div");
        el.classList.add("message");
        if (ev.sender !== myEmail) {
            el.classList.add("sent");
        }
        el.innerHTML = `<p>${ev.message}</p>`;
        document.querySelector(".messages-wrapper").append(el);
        wrapper.scrollTop = wrapper.scrollHeight;
    })
    .listenForWhisper("typing", (data) => {
        data ? (status.textContent = "Typing ...") : "";
        timeout ? clearTimeout(timeout) : "";
        timeout = setTimeout(() => {
            setOnline()
        }, 3000);
    });

input.addEventListener("keydown", () => {
    channel.whisper("typing", true);
});
function setOnline(){
    circle.classList.add('green')
    status.textContent='Online'
}
function setOffline(){
    circle.classList.remove('green')
    status.textContent='Offline'
}
let temp = false
Echo
.join("user-connected")
.here((data) => {
    let tempArray = [];
    data.forEach((e) => {
        tempArray.push(e.email);
    });
    if (tempArray.includes(talkingTo)) {
        setOnline()
    }
})
.joining((data)=>{
    if (data.email===talkingTo) {
        temp ? clearTimeout(temp) : ""
        setOnline()
    }
})
.leaving((data)=>{
    temp = setTimeout(() => {
        if (data.email===talkingTo) {
            setOffline()
            temp = false
        }
    }, 3000);
});
