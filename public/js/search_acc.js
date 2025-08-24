let loading = document.getElementById("loading");
let searchpage = document.getElementById("search_page");
let searchbar = document.getElementById("search");
let searchContent = document.getElementById("search_content");

const searchUsers = () => {
    loading.classList.add("block");
    loading.classList.remove("hidden");

    fetch(window.fetchAccRoute)
        .then((response) => {
            if (response.ok) {
                return response.json();
            } else {
                console.log("no data");
            }
        })
        .then((data) => {
            let searchval = document.getElementById("search").value;
            let accounts = data.accounts || [];
            let limit = searchval === "" ? 0 : 7;
            let filteracc = accounts
                .filter((acc) => acc.name.includes(searchval))
                .slice(0, limit);

            searchContent.innerHTML = "";
            let container = document.createElement("div");
            container.classList.add(
                "flex",
                "flex-col",
                "gap-3",
                "w-full",
                "text-white"
            );

            filteracc.forEach((account) => {
                const div = document.createElement("div");
                div.classList.add("flex", "items-center", "gap-2");
                const anchor = document.createElement("a");
                const image = document.createElement("img");

                const isAuthenticated = data.auth_acc !== null;
                const isCurrentUser =
                    isAuthenticated && account.name === data.auth_acc.name;

                anchor.href = isCurrentUser
                    ? "/show/account"
                    : `/get/acc/by/name/${account.name}`;
                anchor.textContent = account.name;
                anchor.classList.add("p-2", "font-light", "w-full");

                image.classList.add(
                    "w-[50px]",
                    "h-[50px]",
                    "rounded-full",
                    "border",
                    "object-center"
                );
                image.src = account.image;
                image.alt = "profile";

                div.append(image, anchor);
                container.append(div);

                loading.classList.add("hidden");
                loading.classList.remove("flex");
            });

            if (filteracc.length === 0) {
                searchContent.textContent = `no account found with name ${searchval}`;
                console.log("account not found");
            } else {
                searchContent.appendChild(container);
            }
        });
};

function debounce(func, delay) {
    let timer;
    return function (...args) {
        clearTimeout(timer);
        timer = setTimeout(() => {
            func.apply(this, args);
        }, delay);
    };
}

searchbar.addEventListener("input", debounce(searchUsers, 300));
document.getElementById("form").addEventListener("submit", function (e) {
    e.preventDefault();

    let searchedval = document.getElementById("search").value;
    fetch(`/search/user/${encodeURIComponent(searchedval)}`, {
        method: "get",
    })
        .then((res) => {
            loading.classList.remove("hidden");
            loading.classList.add("block");
            if (!res.ok) {
                console.log("server problem");
            } else {
                return res.json();
            }
        })
        .then((data) => {

            let accounts = data.accounts;
            let container = document.createElement("div");
            container.classList.add(
                "flex",
                "flex-col",
                "gap-3",
                "w-full",
                "text-white"
            );

            searchContent.innerHTML = "";

            if (accounts.length !== 0) {
               
                accounts.forEach((account) => {
                    const div = document.createElement("div");
                    div.classList.add("flex", "items-center", "gap-2");
                    const anchor = document.createElement("a");
                    const image = document.createElement("img");

                    const isAuthenticated = data.auth_acc !== null;
                    const isCurrentUser =
                        isAuthenticated && account.name === data.auth_acc.name;

                    anchor.href = isCurrentUser
                        ? "/show/account"
                        : `/get/acc/by/name/${account.name}`;
                    anchor.textContent = account.name;
                    anchor.classList.add("p-2", "font-light", "w-full");

                    image.classList.add(
                        "w-[50px]",
                        "h-[50px]",
                        "rounded-full",
                        "border",
                        "object-center"
                    );
                    image.src = account.image;
                    image.alt = "profile";

                    div.append(image, anchor);
                    container.append(div);

                    loading.classList.add("hidden");
                    loading.classList.remove("flex");
                });
                searchContent.appendChild(container);
            } else {
                searchContent.textContent = `no account found with name ${searchedval}`;
                console.log("account not found");
            }
        });
});
