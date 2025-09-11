document.addEventListener("DOMContentLoaded", async function () {
    let page = 1;
    let block = true;
    let requesting = false;
    const postsContainer = document.getElementById("post-container");
    let posts = null;
    // let connection_err = false;
    const csrfToken = document
        .querySelector("meta[name='csrf-token']")
        .getAttribute("content");

    // createPost function
    const CreatePost = async (post, authuser) => {
        // Create post container
        const postEl = document.createElement("div");
        postEl.className =
            "post-container border-b border-[#434343] w-full p-4";

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

        // Interactivity Icons
        const iconsEl = document.createElement("div");
        iconsEl.className =
            "interactivity-icons flex justify-between items-center text-sm";

        const lefticons = document.createElement("div");
        lefticons.className = "flex gap-7 text-xl";
        const righticon = document.createElement("div");
        righticon.className = "text-xl";
        // like system
        let btn = null;

        try {
            btn = await checkLike(post.id);
            // console.log(`user like status ${post.id} ` + btn);
        } catch (err) {
            console.log(err);
        }
        let postLikes = likes;
        const like = document.createElement("button");
        like.className =
            "text-[#9F9F9F] cursor-pointer flex justify-center items-center gap-2";
        like.innerHTML = `<i class="fa-regular fa-heart"></i> <span class="text-white text-[12px]">${postLikes}</span>`;
        const countSpan = like.querySelector("span");
        // console.log("can you see likes " + postLikes);

        like.classList.add(btn ? "text-red-600" : "text-[#C7C7C7]");
        const icon = like.querySelector("i");
        icon.classList.add(btn ? "fa-solid" : "fa-regular");

        like.addEventListener("dblclick", async function () {
            if (authuser) {
                console.log("before it was btn " + btn);
                btn = !btn;
                console.log("after click " + btn);
                postLikes = btn ? postLikes + 1 : postLikes - 1;
                countSpan.textContent = postLikes;

                this.classList.replace(
                    btn ? "text-[#C7C7C7]" : "text-red-600",
                    btn ? "text-red-600" : "text-[#C7C7C7]"
                );

                icon.classList.replace(
                    btn ? "fa-regular" : "fa-solid",
                    btn ? "fa-solid" : "fa-regular"
                );

                try {
                    btn = await postLikeFunc(post.id, btn);
                } catch (err) {
                    console.log(err);
                }
            } else {
                alert("sign / log in first");
            }
        });

        // comment system
        const comment = document.createElement("button");
        comment.className = "text-[#9F9F9F] cursor-pointer";
        comment.innerHTML =
            '<i class="fa-regular fa-comments"></i><span class="text-white capitalize ml-1 text-[12px]">comments</span>';
        const Comment_container = document.getElementById("comment-container");
        const Comment_section = document.getElementById("comment-section");
        const Comment_box = document.getElementById("comment-box");
        const cross_btn = document.getElementById("cross");
        // comment post & load
        comment.addEventListener("click", function () {
            Comment_section.classList.remove("hidden");
            setTimeout(() => {
                Comment_container.classList.replace(
                    "translate-x-[400px]",
                    "translate-x-[0px]"
                );
            }, 200);
            commentsLoad(post.id, Comment_box);
            commentPost(post.id , Comment_box);
        });
        cross_btn.onclick = function () {
            Comment_container.classList.replace(
                "translate-x-[0px]",
                "translate-x-[400px]"
            );
            setTimeout(() => {
                Comment_section.classList.add("hidden");
            }, 500);
        };

        const share = document.createElement("button");
        share.className = "text-[#9F9F9F] cursor-pointer";
        share.innerHTML = '<i class="fa-solid fa-share"></i>';

        // bookmark system
        const bookmark = document.createElement("button");
        bookmark.className = "text-[#9F9F9F] cursor-pointer";
        bookmark.innerHTML = '<i class="fa-regular fa-bookmark"></i>';
        let bookmarkbtn = false;
        bookmarkbtn = await checkBookmark(post.id);
        const Bookmarkicon = bookmark.querySelector("i");
        Bookmarkicon.classList.replace(
            bookmarkbtn ? "fa-regular" : "fa-solid",
            bookmarkbtn ? "fa-solid" : "fa-regular"
        );
        bookmark.addEventListener("click", async function () {
            bookmarkbtn = !bookmarkbtn;
            console.log(bookmarkbtn);
            Bookmarkicon.classList.replace(
                bookmarkbtn ? "fa-regular" : "fa-solid",
                bookmarkbtn ? "fa-solid" : "fa-regular"
            );
            await postBookmark(post.id, bookmarkbtn);
        });

        lefticons.append(like, comment, share);
        righticon.append(bookmark);
        iconsEl.append(lefticons, righticon);

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
                    '<p class"text-2xl text-red-500 capitalize font-light"><i class="fa-solid fa-rotate-right"></i></p>';
            };
        }
        postEl.appendChild(postText);
        postEl.appendChild(iconsEl);

        // Add to DOM
        postsContainer.appendChild(postEl);
    };

    // infinite loading function
    const infiniteLoading = async () => {
        if (requesting) return;
        requesting = true;
        let loading = document.getElementById("loader");
        loading.classList.replace("hidden", "flex-col");

        try {
            const res = await fetch(`/load/post/${page}`, {
                method: "GET",
            });
            // json res
            if (res.ok) {
                const data = await res.json();
                posts = data.posts ?? null;
                console.log(posts);
                authuser = data.authuser ?? null;
                if (Array.isArray(posts) && posts.length > 0) {
                    await Promise.allSettled(
                        posts.map((post) => CreatePost(post, authuser))
                    );
                    page++;
                } else {
                    console.log("res is zero");
                }
            } else {
                throw new Error("failed to fetch the posts");
            }
        } catch (err) {
            loading.classList.replace("flex-col", "hidden");
            requesting = true;
            postsContainer.appendChild(err);
            console.log(err.message);
        } finally {
            loading.classList.replace("flex-col", "hidden");
            if (posts.length == 0) {
                const noposts = document.createElement("p");
                noposts.textContent = "the end";
                noposts.className =
                    "text-xl text-white w-full text-center capitalize p-5";
                postsContainer.append(noposts);
                requesting = true;
            }
            // else if(connection_err) {
            //      loading.classList.replace("flex-col", "hidden");
            //     const connection = document.createElement("p");
            //     connection.textContent = "plz check your internet";
            //     connection.className =
            //         "text-xl text-red-500 w-full opacity-70 text-center capitalize p-5";
            //     postsContainer.append(connection);
            //     console.log('connection err');
            //     requesting = true;
            // }
            else {
                requesting = false;
            }
        }
    };

    // postlike Fucntion
    const postLikeFunc = async (id, btn) => {
        try {
            let islike = btn;
            let myheader = new Headers();
            myheader.append("Content-Type", "application/json");
            myheader.append("X-CSRF-TOKEN", csrfToken);

            const likesRes = await fetch("/like/post", {
                method: "POST",
                headers: myheader,
                body: JSON.stringify(
                    islike ? { likePost: id } : { unlikePost: id }
                ),
            });

            if (likesRes.ok) {
                const data = await likesRes.json();
                if (data.like !== undefined) {
                    return data.like;
                } else if (data.unlike !== undefined) {
                    return data.unlike;
                }
            } else {
                console.log("failed to fetch");
            }
        } catch (err) {
            console.error("Like/unlike failed:", err);
        }
    };

    // bookmark Function
    const postBookmark = async (id, btn) => {
        try {
            const isbookmark = btn;
            let myheader = new Headers();
            myheader.append("Content-Type", "application/json");
            myheader.append("X-CSRF-TOKEN", csrfToken);

            const bookmarkRes = await fetch("save/bookmark", {
                method: "POST",
                headers: myheader,
                body: JSON.stringify(
                    isbookmark ? { bookmark: id } : { removeMark: id }
                ),
            });

            if (bookmarkRes.ok) {
                const data = await bookmarkRes.json();
                if (data.bookmark !== undefined) {
                    return data.bookmark;
                } else if (data.remove !== undefined) {
                    return data.removeMark;
                }
            } else {
                console.log("failed to fetch");
            }
        } catch (err) {
            console.error("Like/unlike failed:", err);
        }
    };

    // Will store like status
    const checkLike = async (id) => {
        try {
            const res = await fetch(`/check/like/${id}`, {
                method: "GET",
            });

            if (res.ok) {
                const data = await res.json();
                likes = data.total_likes;
                // console.log(`get total likes of post ` + likes);
                return data.check;
            } else {
                console.log("fail to check");
                return false;
            }
        } catch (err) {
            console.error("Failed to check like:", err);
            return false;
        }
    };

    // Will store like status
    const checkBookmark = async (id) => {
        try {
            const res = await fetch(`check/bookmark/${id}`, {
                method: "GET",
            });

            if (res.ok) {
                const data = await res.json();
                return data.check;
            } else {
                return false;
            }
        } catch (err) {
            return false;
        }
    };

    const commentsLoad = async (id, container) => {
        let page = 1;
        const loader = document.getElementById("Comments-loader");
        container.innerHTML = "";
        loader.classList.replace("hidden", "block");
        setTimeout(async () => {
            try {
                const res = await fetch(`/comments/load/${id}/${page}`, {
                    method: "get",
                });

                if (res.ok) {
                    const data = await res.json();
                    page++;
                    const response_comments = data.comments;
                    if (response_comments.length === 0) {
                        loader.classList.replace("block", "hidden");
                        return (container.innerHTML =
                            '<p class="text-center text-white font-light capitalize">no comments</p>');
                    }
                    response_comments.forEach((comment) => {
                        const commentWrapper = document.createElement("div");
                        commentWrapper.className = "comment-wrapper mb-6";

                        const accountEl = document.createElement("div");
                        accountEl.className =
                            "post-account flex items-center space-x-3 mb-3";

                        const accImg = document.createElement("img");
                        accImg.className =
                            "acc-image w-10 h-10 rounded-full bg-gray-200";
                        accImg.src =
                            comment.useracc?.image || "/default-profile.png";
                        accImg.style.objectFit = "cover";

                        const isCurrentUser =
                            data.auth_acc?.name === comment.useracc?.name;

                        const accInfo = document.createElement("div");
                        accInfo.className = "acc-info";

                        const userName = comment.useracc?.name || "Unknown";
                        const profileLink = isCurrentUser
                            ? "/show/account"
                            : `/get/acc/by/name/${userName}`;

                        accInfo.innerHTML = `
        <a href="${profileLink}" class="acc-name text-white font-light hover:underline">
            ${userName}
        </a>
        <div class="acc-timestamp text-sm text-[#717171]">
            ${timeAgo(comment.created_at)}
        </div>
    `;

                        const commentContent = document.createElement("p");
                        commentContent.className =
                            "text-white text-sm ml-[53px]";
                        commentContent.textContent =
                            comment.comments || "[No comment content]";

                        accountEl.appendChild(accImg);
                        accountEl.appendChild(accInfo);
                        commentWrapper.appendChild(accountEl);
                        commentWrapper.appendChild(commentContent);
                        loader.classList.replace("block", "hidden");
                        container.appendChild(commentWrapper);
                    });
                } else {
                    console.log("response fail");
                }
            } catch {
                console.log("err");
            } finally {
            }
        }, 1000);
    };

    const commentPost = (id,CommentBox) => {
        // comment post
        const form = document.getElementById("comment-form");
        form.onsubmit = async function (e) {
            console.log(id);
            let commentText = document.getElementById("messageInput").value;
            e.preventDefault();
            const send_button = document.getElementById("sendButton");
            const loading_snnipt = document.getElementById("loading");
            send_button.style.display = "none";
            loading_snnipt.classList.replace("hidden", "flex");
            let myheader = new Headers();
            myheader.append("Content-Type", "application/json");
            myheader.append("X-CSRF-TOKEN", csrfToken);

            try {
                const res = await fetch("/comment/post", {
                    method: "post",
                    headers: myheader,
                    body: JSON.stringify({
                        post_id: id,
                        comment: commentText,
                    }),
                });
                if (res.ok) {
                    const data = await res.json();
                    const user_acc = data.auth_acc;
                    if (!user_acc) {
                        throw new Error("log in first");
                    }
                    const commentWrapper = document.createElement("div");
                    commentWrapper.className = "comment-wrapper mb-6";

                    const accountEl = document.createElement("div");
                    accountEl.className =
                        "post-account flex items-center space-x-3 mb-3";

                    const accImg = document.createElement("img");
                    accImg.className =
                        "acc-image w-10 h-10 rounded-full bg-gray-200";
                    accImg.src = user_acc?.image || "/default-profile.png";
                    accImg.style.objectFit = "cover";

                    const accInfo = document.createElement("div");
                    accInfo.className = "acc-info";

                    const userName = user_acc?.name || "Unknown";
                    const profileLink = "/show/account";

                    accInfo.innerHTML = `
        <a href="${profileLink}" class="acc-name text-white font-light hover:underline">
            ${userName}
        </a>
        <div class="acc-timestamp text-sm text-[#717171]">
            ${timeAgo(new Date())}
        </div>
    `;

                    const commentContent = document.createElement("p");
                    commentContent.className = "text-white text-sm ml-[53px]";
                    commentContent.textContent =
                        commentText || "[No comment content]";

                    document.getElementById("messageInput").value = "";
                    accountEl.appendChild(accImg);
                    accountEl.appendChild(accInfo);
                    commentWrapper.appendChild(accountEl);
                    commentWrapper.appendChild(commentContent);
                    send_button.style.display = "flex";
                    loading_snnipt.classList.replace("flex", "hidden");
                    setTimeout(() => {
                        CommentBox.prepend(commentWrapper);
                    }, 500);
                }
            } catch (err) {
                console.log(err.message);
                alert(err.message);
            } finally {
            }
        };
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

    window.addEventListener("scroll", function () {
        if (
            window.innerHeight + window.scrollY >=
            document.body.offsetHeight - 400
        ) {
            infiniteLoading();
        }
    });

    // initial render
    if (block) {
        await infiniteLoading();
        block = false;
    }
});
