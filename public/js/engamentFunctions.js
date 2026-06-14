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
            if (btn) {
                btn.textContent = "Unfollow";
                btn.onclick = () => unfollow(authorId);
            }
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
            if (btn) {
                btn.textContent = "Follow";
                btn.onclick = () => follow(authorId);
            }
        })
        .catch((error) => console.error("Unfollow error:", error));
}

function toggleLike(postId) {
    fetch(`/posts/${postId}/like`, {
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
            const btn = document.getElementById(`like-btn-${postId}`);
            const count = document.getElementById(`like-count-${postId}`);
            if (btn) {
                if (data.liked) {
                    btn.classList.add("bg-red-500", "text-white", "rounded-full", "p-1");
                    btn.classList.remove("text-on-surface-variant");
                } else {
                    btn.classList.remove("bg-red-500", "text-white", "rounded-full", "p-1");
                    btn.classList.add("text-on-surface-variant");
                }
            }
            if (count) {
                count.textContent = data.likes_count;
            }
        })
        .catch((error) => console.error("Like error:", error));
}

function submitComment(postId) {
    const content = document.getElementById(`comment-content-${postId}`).value;
    if (!content.trim()) return;

    fetch(`/posts/${postId}/comment`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ content: content }),
        })
        .then((response) => {
            if (!response.ok) throw new Error(response.statusText);
            return response.json();
        })
        .then((data) => {
            if (data.success) {
                document.getElementById(`comment-content-${postId}`).value = "";
                // Optionally reload or append comment
                location.reload(); // Simple way to show the new comment
            }
        })
        .catch((error) => console.error("Comment error:", error));
}
