document.addEventListener("DOMContentLoaded", async function () {
    await getNotifications();
    setTimeout(() => {
        window.Echo.private(`live-Notification.${window.userId}`).listen(
            "LiveNotificationEvent",
            (e) => {
                const noitfy = document.getElementById("notify");
                noitfy.classList.replace("hidden", "block");
                const notify_icon =
                    document.querySelector(".fa-solid.fa-heart");
                notify_icon.onclick = async function () {
                    noitfy.classList.add("hidden");
                    try {
                        const csrf_token = document
                            .querySelector("meta[name='csrf-token']")
                            .getAttribute("content");
                        const headers = new Headers();
                        headers.append("Content-Type", "application/json");
                        headers.append("X-CSRF-TOKEN", csrf_token);
                        const data = await fetch(
                            "/markasreadall/notifications",
                            {
                                method: "post",
                                headers: headers,
                                body: JSON.stringify({ mark: true }),
                            }
                        );
                    } catch (error) {
                        // console.error(error);
                    }
                };
            }
        );
    }, 200);
});

const getNotifications = async () => {
    const today = document.getElementById("today");
    const tommorows = document.getElementById("tomorrow");
    const loader = document.querySelectorAll(".l");
    const week = document.getElementById("week");
    let today_notification = false;
    let tommorow_notification = false;
    let week_notification = false;
    try {
        const getNotify = await fetch("/get/notifications", {
            method: "get",
        });

        if (getNotify.ok) {
            const data = await getNotify.json();
            data.forEach((notify) => {
                const commentWrapper = document.createElement("div");
                commentWrapper.className = "comment-wrapper mb-6";

                const accountEl = document.createElement("div");
                accountEl.className =
                    "post-account flex items-center space-x-3 mb-3";

                const accImg = document.createElement("img");
                accImg.className =
                    "acc-image w-10 h-10 rounded-full bg-gray-200";
                accImg.src = notify.user?.image || "/default-profile.png";
                accImg.style.objectFit = "cover";

                const accInfo = document.createElement("div");
                accInfo.className = "acc-info";

                const userName = notify.user?.name || "Unknown";
                const profileLink = `/get/acc/by/name/${userName}`;

                accInfo.innerHTML = `
        <a href="${profileLink}" class="acc-name text-white font-light hover:underline">
            ${userName}
        </a>
        <div class="acc-timestamp text-sm text-[#717171]">
            ${timeAgo(notify.timestamp)}
        </div>
    `;

                const commentContent = document.createElement("p");
                commentContent.className = "text-white text-sm ml-[53px]";
                commentContent.textContent =
                    notify.message || "[No comment content]";

                accountEl.appendChild(accImg);
                accountEl.appendChild(accInfo);
                commentWrapper.appendChild(accountEl);
                commentWrapper.appendChild(commentContent);
                loader.forEach((l) => {
                    l.classList.replace("flex", "hidden");
                });

                const now = new Date();
                const then = new Date(notify.timestamp);
                const seconds = Math.floor((now - then) / 1000);
                const day = Math.floor(seconds / 86400);

                if (day < 1) {
                    today.appendChild(commentWrapper);
                    today_notification = true;
                } else if (day >= 1 && day < 7) {
                    tommorows.appendChild(commentWrapper);
                    tommorow_notification = true;
                } else if (day >= 7) {
                    week.appendChild(commentWrapper);
                    week_notification = true;
                }
            });

            if (!today_notification) {
                const no_notification = document.createElement("h1");
                no_notification.className =
                    "text-sm font-semibold capitalize text-white";
                no_notification.textContent = "no notification yet";
                today.appendChild(no_notification);
                loader.forEach((l) => {
                    l.classList.replace("flex", "hidden");
                });
            }
            if (!tommorow_notification) {
                const no_notification = document.createElement("h1");
                no_notification.className =
                    "text-sm font-semibold capitalize text-white";
                no_notification.textContent = "no notification yet";
                tommorows.appendChild(no_notification);
                loader.forEach((l) => {
                    l.classList.replace("flex", "hidden");
                });
            }
            if (!week_notification) {
                const no_notification = document.createElement("h1");
                no_notification.className =
                    "text-sm font-semibold capitalize text-white";
                no_notification.textContent = "no notification yet";
                week.appendChild(no_notification);
                loader.forEach((l) => {
                    l.classList.replace("flex", "hidden");
                });
            }
        } else {
            console.log("failed to get message");
        }
    } catch (error) {
        console.error(error);
    }
};

const timeAgo = (time) => {
    const now = new Date();
    const then = new Date(time);
    const seconds = Math.floor((now - then) / 1000);

    if (seconds < 10) {
        return "now";
    }
    if (seconds < 60) {
        return `${seconds}s ago`;
    }
    const minutes = Math.floor(seconds / 60);
    if (minutes < 60) {
        return `${minutes}m ago`;
    }
    const hours = Math.floor(minutes / 60);
    if (hours < 24) {
        return `${hours}h ago`;
    }
    const days = Math.floor(hours / 24);
    if (days < 365) {
        return `${days}d ago`;
    }
};
