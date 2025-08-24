document.addEventListener("DOMContentLoaded", async function () {
    await getNotifications();
});

const getNotifications = async () => {
    try {
       const getNotify = await fetch("/get/notifications", {
            method: "get",
        });

        if(getNotify.ok){
            const data = getNotify.json();
            console.log(data);
        }else{
            console.log('failed to get message')
        }

    } catch (err) {}
};
