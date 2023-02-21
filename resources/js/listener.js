import "./bootstrap";

Echo.private("base-channel").listen("BasicMessage", (e) => {
    console.log(e);
});
