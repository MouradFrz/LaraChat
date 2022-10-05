import "./bootstrap"
const myEmail = email
const id = getID
const channel = Echo.private(`message-channel-${id}`)
const wrapper = document.querySelector(".messages-wrapper")
const input = document.querySelector(".input-field")
const typing = document.querySelector("#typing")
let timeout = false
typing.style.display = "none"
channel
    .subscribed(() => {})
    .listen(".SendMessage", (ev) => {
        typing.style.display = "none"
        let el = document.createElement("div")
        el.classList.add("message")
        if (ev.sender !== myEmail) {
            el.classList.add("sent")
        }
        el.innerHTML = `<p>${ev.message}</p>`
        document.querySelector(".messages-wrapper").append(el)
        wrapper.scrollTop = wrapper.scrollHeight
    })

input.addEventListener("keydown", () => {
    channel.whisper("typing", true)
})

channel.listenForWhisper("typing", (data) => {
    data ? (typing.style.display = "block") : ""
    timeout ? clearTimeout(timeout) : ""
    timeout = setTimeout(() => {
        typing.style.display = "none"
    }, 3000)
})
