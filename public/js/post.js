document.getElementById("post-form").addEventListener("submit", function (e) {
    // prevent page refeshing
    e.preventDefault();
    const button = document.getElementById("post-button");
    const loading = document.getElementById("loading");
    const csrftokenforpost = document
        .querySelector('meta[name = "csrf-token"]')
        .getAttribute('content');
    const about = document.getElementById("about_post").value ?? null;
    if (about == null) {
        alert("write something");
        return;
    }
    const postimage = document.getElementById("image");
    const file = postimage.files[0] ?? null;
    // showing loading animation
    button.classList.add("hidden");
    loading.classList.replace("hidden", "flex");
    // storing form data
    const post_data = new FormData();
    post_data.append("post_image", file);
    post_data.append("post_text", about);
    // sending data
    fetch("/posting", {
        method: "post",
        headers: {
            "X-CSRF-TOKEN": csrftokenforpost,
        },
        body: post_data,
    })
        .then((res) => {
            if (res.ok) {
                return res.json();
            } else {
                console.log("connection issue");
            }
        })
        .then((data) => {
            if (data.posting === "success") {
                button.classList.replace("hidden" , "block");
                loading.classList.replace("flex", "hidden");
                button.textContent = "posted";
                button.classList.add(
                    "text-green-400",
                    'rounded-md',
                    'font-light'
                );
                button.classList.replace('bg-white' , 'bg-transparent');
                setTimeout(() => {
                    window.location.href = "/welcometocloud";
                }, 500);
            }
        })
        .catch((err) => {
            console.error('err:' , err);
            window.errMessage = err;
            window.location.href = "login";
        });
});
