const followerToggle = () => {
    let follower_account = document.getElementById("followers_account");
    follower_account.classList.toggle("hidden");
    document.getElementById("followings_account").classList.add("hidden");
};
const followingToggle = () => {
    let following_accounts = document.getElementById("followings_account");
    following_accounts.classList.toggle("hidden");
    document.getElementById("followers_account").classList.add("hidden");
};

let follow_button = document.getElementById("follow");
let loading = document.getElementById("loading");
let unfollow = document.getElementById("unfollow");
let request = false;

document.addEventListener("DOMContentLoaded", function () {
    if (!window.authCheck) {
        request = true;
        loading.classList.remove("block");
        loading.classList.add("hidden");
        follow_button.classList.add("block");
        follow_button.classList.remove("hidden");
        follow_button.onclick = function () {
            alert("sign/log in first");
        };
        return;
    }
   
    const account_id = window.accountid;
    follow_button.classList.remove("block");
    follow_button.classList.add("hidden");
    loading.classList.remove("hidden");
    loading.classList.add("block");
    fetch(window.checkinteractivity, {
        method: "post",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": window.csrfToken,
        },
        body: JSON.stringify({ id: account_id }),
    })
        .then((response) => {
            if (response.ok) {
                return response.json();
            } else {
                console.log("response fail");
            }
        })
        .then((data) => {
            if (data.message === "sucess") {
                loading.classList.replace("block", "hidden");
                unfollow.classList.replace("hidden", "block");
                follow_button.classList.replace("block", "hidden");
            } else if (data.message === "unsucess") {
                loading.classList.remove("block");
                loading.classList.add("hidden");
                unfollow.classList.add("hidden");
                unfollow.classList.remove("block");
                follow_button.classList.add("block");
                follow_button.classList.remove("hidden");
            }
        });
});

follow_button.addEventListener("click", function () {
    if (request) return;
    request = false;
    const account_to_be_followed_id = this.getAttribute("send-data-id");
    follow_button.classList.remove("block");
    follow_button.classList.add("hidden");
    loading.classList.remove("hidden");
    loading.classList.add("block");

    fetch(window.interacitivity, {
        method: "post",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": window.csrfToken,
        },
        body: JSON.stringify({ id: account_to_be_followed_id }),
    })
        .then((response) => {
            if (response.ok) {
                return response.json();
            } else {
                console.log("response fail");
            }
        })
        .then((data) => {
            if (data.message) {
                loading.classList.remove("block");
                loading.classList.add("hidden");
                unfollow.classList.add("block");
                unfollow.classList.remove("hidden");
            } else if (data.error) {
                alert("sign/log in first");
            }
        })
        .catch((error) => {
            console.error("network or json error", error);
        });
});
unfollow.addEventListener("click", function () {
    if (request) return;
    request = false;
    const account_to_be_unfollowed_id = this.getAttribute("send-data-id");
    unfollow.classList.remove("block");
    unfollow.classList.add("hidden");
    loading.classList.remove("hidden");
    loading.classList.add("block");

    fetch("/account/unfollow", {
        method: "post",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": window.csrfToken,
        },
        body: JSON.stringify({ id: account_to_be_unfollowed_id }),
    })
        .then((response) => {
            if (response.ok) {
                return response.json();
            } else {
                console.log("response fail");
            }
        })
        .then((data) => {
            if (data.message) {
                loading.classList.remove("block");
                loading.classList.add("hidden");
                follow_button.classList.add("block");
                follow_button.classList.remove("hidden");
            }
        })
        .catch((error) => {
            console.error("network or json error", error);
        });
});
