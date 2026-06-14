function hi() {
    showToast("Followed successfully!");
}

function follow(authorId) {
    fetch(`/follow/${authorId}`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                "Content-Type": "application/json",
            },
        })
        .then((response) => {
            if (!response.ok) throw new Error(response.statusText);
            return response.json();
        })
        .then((data) => {
            const btn = document.getElementById(`follow-btn-${authorId}`);
            btn.textContent = "Unfollow";
            btn.onclick = () => unfollow(authorId);
            showToast(data.message ?? "Followed successfully!");
        })
        .catch((error) => console.error("Follow error:", error));
}

function unfollow(authorId) {
    fetch(`/unfollow/${authorId}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                "Content-Type": "application/json",
            },
        })
        .then((response) => {
            if (!response.ok) throw new Error(response.statusText);
            return response.json();
        })
        .then((data) => {
            const btn = document.getElementById(`follow-btn-${authorId}`);
            btn.textContent = "Follow";
            btn.onclick = () => follow(authorId);
            showToast(data.message ?? "Unfollowed successfully!");
        })
        .catch((error) => console.error("Unfollow error:", error));
}
