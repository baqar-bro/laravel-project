document.addEventListener("DOMContentLoaded", function () {
    let loading = document.getElementById("loading");
    let notfound = document.getElementById("account_not_found");
    let showAcc = document.getElementById("show_account");
    const no_post = document.getElementById("no-post");
    const profile_activity = document.getElementById("activity");

    loading.classList.remove("hidden");
    loading.classList.add("flex");

    fetch(window.userAccountInfoUrl)
        .then((response) => {
            if (response.ok) {
                return response.json();
            }
        })
        .then(async (data) => {
            if (!data.account) {
                document.getElementById("error_msg").textContent = data.error;
                loading.classList.add("hidden");
                loading.classList.remove("flex");
                notfound.classList.remove("hidden");
                notfound.classList.add("flex");
            } else {
                loading.classList.add("hidden");
                loading.classList.remove("flex");
                showAcc.classList.remove("hidden");
                showAcc.classList.add("flex");

                document.getElementById("acc_name").textContent =
                    data.account.name;
                document.getElementById("profile_image").src = data.image_url;
                document.getElementById("about_acc").textContent =
                    data.account.about;
                document.getElementById("follower_count").textContent =
                    data.followers;
                document.getElementById("following_count").textContent =
                    data.followings;
                document.getElementById("acc_post").textContent =
                    data.posts_count;

                if (data.posts) {
                    const postsdata = data.posts;
                    const account = data.account;
                    const likePosts = data.like_posts;
                    const bookmarkPosts = data.bookmark_posts;
                    const loadposts = async () => {
                        const eyebtn = document.getElementById("eye");
                        const likebtn = document.getElementById("like");
                        const bookmarkbtn = document.getElementById("bookmark");
                        const postcontainer = document.createElement("div");
                        const likepostcontainer = document.createElement("div");
                        const bookmarkpostscontainer =
                            document.createElement("div");

                        await Promise.allSettled(
                            postsdata.map(async (post) => {
                                CreatePost(account, post, postcontainer);
                            })
                        );
                        await Promise.allSettled(
                            likePosts.map(async (post) => {
                                likePost(post, account, likepostcontainer);
                            })
                        );
                        await Promise.allSettled(
                            bookmarkPosts.map(async (post) => {
                                BookmarkPost(
                                    post,
                                    account,
                                    bookmarkpostscontainer
                                );
                            })
                        );

                        no_post.classList.add("hidden");
                        profile_activity.appendChild(postcontainer);
                        likebtn.onclick = () => switchContainer(likepostcontainer);
                        bookmarkbtn.onclick = () =>
                            switchContainer(bookmarkpostscontainer);
                        eyebtn.onclick = () => switchContainer(postcontainer);
                    };
                    await loadposts();
                    function switchContainer(newContainer) {
                        profile_activity.innerHTML = "";

                        newContainer.classList.add("slide-in");

                        profile_activity.appendChild(newContainer);

                        newContainer.addEventListener(
                            "animationend",
                            () => {
                                newContainer.classList.remove("slide-in");
                            },
                            { once: true }
                        );
                    }
                }

                if (data.follower_accounts) {
                    let followers = data.follower_accounts;
                    let container = document.createElement("div");
                    container.classList.add(
                        "flex",
                        "flex-col",
                        "gap-3",
                        "w-full",
                        "text-white"
                    );
                    followers.forEach((follower) => {
                        let followerdiv = document.createElement("div");
                        followerdiv.classList.add(
                            "border",
                            "border-white",
                            "p-2",
                            "border-l-0",
                            "border-r-0",
                            "border-t-0",
                            "font-light"
                        );
                        followerdiv.textContent = follower.name;
                        container.append(followerdiv);
                    });
                    document
                        .getElementById("followers_account")
                        .appendChild(container);
                }
                if (data.following_accounts) {
                    let followers = data.following_accounts;
                    let container = document.createElement("div");
                    container.classList.add(
                        "flex",
                        "flex-col",
                        "gap-3",
                        "w-full",
                        "text-white"
                    );
                    followers.forEach((follower) => {
                        let followerdiv = document.createElement("div");
                        followerdiv.classList.add(
                            "border-1",
                            "border-white",
                            "border-l-0",
                            "p-2",
                            "border-r-0",
                            "border-t-0",
                            "font-light"
                        );
                        followerdiv.textContent = follower.name;
                        container.append(followerdiv);
                    });
                    document
                        .getElementById("followings_account")
                        .appendChild(container);
                }
            }
        });
});

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

const CreatePost = async (account, post, container) => {
    // Create post container
    const postEl = document.createElement("div");
    postEl.className = "post-container border-b border-gray-300 w-full p-4";

    // Account Info
    const accountEl = document.createElement("div");
    accountEl.className = "post-account flex items-center space-x-3 mb-3";

    const accImg = document.createElement("img");
    accImg.className = "acc-image w-10 h-10 rounded-full bg-gray-200";
    accImg.src = account.image;
    accImg.style.objectFit = "cover";

    const accInfo = document.createElement("div");
    accInfo.className = "acc-info";

    accInfo.innerHTML = `
                        <a href="" 
                        class="acc-name text-white font-light">
                        ${account?.name || "Unknown"}</a>;
                        <div class="acc-timestamp text-sm text-[#717171]">${timeAgo(
                            post.created_at
                        )}</div>`;

    accountEl.appendChild(accImg);
    accountEl.appendChild(accInfo);

    // Post Image
    const postImage = new Image();
    postImage.className =
        "post-image bg-gray-300 rounded mb-3 text-balck text-center";
    postImage.style.width = "max";
    postImage.style.height = "auto";
    postImage.style.maxWidth = "none";
    postImage.src = post.image;
    postImage.alt = "image err";

    // Post Text
    const postText = document.createElement("div");
    postText.className = "post-text text-white font-medium text-sm mb-3";
    postText.textContent = post.text;

    // image place book first
    const imageWrapper = document.createElement("div");
    imageWrapper.className = "mb-3";
    imageWrapper.style.width = "max";
    imageWrapper.style.height = "auto";
    imageWrapper.style.maxWidth = "none";

    // loading
    const imageload = document.createElement("div");
    imageload.className =
        "post-image bg-black flex justify-center items-center rounded mb-3 text-black text-center";
    imageload.style.width = "400px";
    imageload.style.height = "200px";
    imageload.style.maxWidth = "none";
    imageload.innerHTML = `<div class="flex flex-row gap-2">
  <div class="w-4 h-4 rounded-full bg-black animate-bounce [animation-delay:.7s]"></div>
  <div class="w-4 h-4 rounded-full bg-black animate-bounce [animation-delay:.3s]"></div>
  <div class="w-4 h-4 rounded-full bg-black animate-bounce [animation-delay:.7s]"></div>
</div>`;

    // Assemble post
    postEl.appendChild(accountEl);
    if (post.image !== null) {
        imageWrapper.appendChild(imageload);
        postEl.appendChild(imageWrapper);
        postImage.onload = () => {
            imageWrapper.removeChild(imageload);
            imageWrapper.appendChild(postImage);
        };
        postImage.onerror = () => {
            imageload.innerHTML =
                '<p class"text-xl text-red-500 capitalize font-light"><i class="fa-solid fa-rotate-right"></i></p>';
            connection_err = true;
        };
    }
    postEl.appendChild(postText);

    // Add to DOM
    container.appendChild(postEl);
};

const likePost = async (post, authuser, container) => {
    // Create post container
    const postEl = document.createElement("div");
    postEl.className = "post-container border-b border-gray-300 w-full p-4";

    // Account Info
    const accountEl = document.createElement("div");
    accountEl.className = "post-account flex items-center space-x-3 mb-3";

    const accImg = document.createElement("img");
    accImg.className = "acc-image w-10 h-10 rounded-full bg-gray-200";
    accImg.src = `${post.useracc.image}`;
    accImg.style.objectFit = "cover";

    const currentUser = authuser?.name === post.useracc?.name;

    const accInfo = document.createElement("div");
    accInfo.className = "acc-info";

    accInfo.innerHTML = `
                        <a href="${
                            currentUser
                                ? "/show/account"
                                : `/get/acc/by/name/${post.useracc?.name}`
                        }" 
                        class="acc-name text-white font-light">
                        ${post.useracc?.name || "Unknown"}</a>;
                        <div class="acc-timestamp text-sm text-[#717171]">${timeAgo(
                            post.created_at
                        )}</div>`;

    accountEl.appendChild(accImg);
    accountEl.appendChild(accInfo);

    // Post Image
    const postImage = new Image();
    postImage.className =
        "post-image bg-gray-300 rounded mb-3 text-balck text-center";
    postImage.style.width = "max";
    postImage.style.height = "auto";
    postImage.style.maxWidth = "none";
    postImage.src = post.image;
    postImage.alt = "image err";

    // Post Text
    const postText = document.createElement("div");
    postText.className = "post-text text-white font-medium text-sm mb-3";
    postText.textContent = post.text;

    // image place book first
    const imageWrapper = document.createElement("div");
    imageWrapper.className = "mb-3";
    imageWrapper.style.width = "max";
    imageWrapper.style.height = "auto";
    imageWrapper.style.maxWidth = "none";

    // loading
    const imageload = document.createElement("div");
    imageload.className =
        "post-image bg-black flex justify-center items-center rounded mb-3 text-black text-center";
    imageload.style.width = "400px";
    imageload.style.height = "200px";
    imageload.style.maxWidth = "none";
    imageload.innerHTML = `<div class="flex flex-row gap-2">
  <div class="w-4 h-4 rounded-full bg-black animate-bounce [animation-delay:.7s]"></div>
  <div class="w-4 h-4 rounded-full bg-black animate-bounce [animation-delay:.3s]"></div>
  <div class="w-4 h-4 rounded-full bg-black animate-bounce [animation-delay:.7s]"></div>
</div>`;

    // Assemble post
    postEl.appendChild(accountEl);
    if (post.image !== null) {
        imageWrapper.appendChild(imageload);
        postEl.appendChild(imageWrapper);
        postImage.onload = () => {
            imageWrapper.removeChild(imageload);
            imageWrapper.appendChild(postImage);
        };
        postImage.onerror = () => {
            imageload.innerHTML =
                '<p class"text-xl text-red-500 capitalize font-light"><i class="fa-solid fa-rotate-right"></i></p>';
            connection_err = true;
        };
    }
    postEl.appendChild(postText);

    // Add to DOM
    container.appendChild(postEl);
};

const BookmarkPost = async (post, authuser, container) => {
    // Create post container
    const postEl = document.createElement("div");
    postEl.className = "post-container border-b border-gray-300 w-full p-4";

    // Account Info
    const accountEl = document.createElement("div");
    accountEl.className = "post-account flex items-center space-x-3 mb-3";

    const accImg = document.createElement("img");
    accImg.className = "acc-image w-10 h-10 rounded-full bg-gray-200";
    accImg.src = `${post.useracc.image}`;
    accImg.style.objectFit = "cover";

    const currentUser = authuser?.name === post.useracc?.name;

    const accInfo = document.createElement("div");
    accInfo.className = "acc-info";

    accInfo.innerHTML = `
                        <a href="${
                            currentUser
                                ? "/show/account"
                                : `/get/acc/by/name/${post.useracc?.name}`
                        }" 
                        class="acc-name text-white font-light">
                        ${post.useracc?.name || "Unknown"}</a>;
                        <div class="acc-timestamp text-sm text-[#717171]">${timeAgo(
                            post.created_at
                        )}</div>`;

    accountEl.appendChild(accImg);
    accountEl.appendChild(accInfo);

    // Post Image
    const postImage = new Image();
    postImage.className =
        "post-image bg-gray-300 rounded mb-3 text-balck text-center";
    postImage.style.width = "max";
    postImage.style.height = "auto";
    postImage.style.maxWidth = "none";
    postImage.src = post.image;
    postImage.alt = "image err";

    // Post Text
    const postText = document.createElement("div");
    postText.className = "post-text text-white font-medium text-sm mb-3";
    postText.textContent = post.text;

    // image place book first
    const imageWrapper = document.createElement("div");
    imageWrapper.className = "mb-3";
    imageWrapper.style.width = "max";
    imageWrapper.style.height = "auto";
    imageWrapper.style.maxWidth = "none";

    // loading
    const imageload = document.createElement("div");
    imageload.className =
        "post-image bg-black flex justify-center items-center rounded mb-3 text-black text-center";
    imageload.style.width = "400px";
    imageload.style.height = "200px";
    imageload.style.maxWidth = "none";
    imageload.innerHTML = `<div class="flex flex-row gap-2">
  <div class="w-4 h-4 rounded-full bg-black animate-bounce [animation-delay:.7s]"></div>
  <div class="w-4 h-4 rounded-full bg-black animate-bounce [animation-delay:.3s]"></div>
  <div class="w-4 h-4 rounded-full bg-black animate-bounce [animation-delay:.7s]"></div>
</div>`;

    // Assemble post
    postEl.appendChild(accountEl);
    if (post.image !== null) {
        imageWrapper.appendChild(imageload);
        postEl.appendChild(imageWrapper);
        postImage.onload = () => {
            imageWrapper.removeChild(imageload);
            imageWrapper.appendChild(postImage);
        };
        postImage.onerror = () => {
            imageload.innerHTML =
                '<p class"text-xl text-red-500 capitalize font-light"><i class="fa-solid fa-rotate-right"></i></p>';
            connection_err = true;
        };
    }
    postEl.appendChild(postText);

    // Add to DOM
    container.appendChild(postEl);
};

const timeAgo = (time) => {
    const now = new Date();
    const then = new Date(time);
    const seconds = Math.floor((now - then) / 1000);

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
