# Engagement Implementation Documentation

This document provides a detailed technical explanation of the engagement features (Follow, Like, Comment) implemented in the Write-ai application, focusing on the integration between the JavaScript frontend, the Laravel backend, and the DOM.

---

## 1. Overview
The engagement system allows users to interact with authors and posts through:
- **Following/Unfollowing authors.**
- **Liking/Unliking posts** (with dynamic UI feedback).
- **Commenting on posts** (via a modal interface).
- **Notifications** (automatic alerts for authors when someone interacts with their content).

---

## 2. Communication Layer: The Fetch API

The application uses the modern **Fetch API** for all engagement actions. This allows for "Asynchronous" interactions, meaning the page doesn't need to reload when you like a post or follow a user.

### Standard Request Structure
Every engagement function follows this pattern:

```javascript
fetch(url, {
    method: "POST", // or DELETE
    headers: {
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        "Content-Type": "application/json",
        "Accept": "application/json"
    },
    body: JSON.stringify({ /* data if needed */ })
})
.then(response => response.json())
.then(data => { /* Update DOM here */ })
.catch(error => console.error(error));
```

#### Key Components:
- **CSRF Protection**: Laravel requires a CSRF token for security. We extract this from the `<meta>` tag in the header and send it as `X-CSRF-TOKEN`.
- **JSON Handling**: We use `JSON.stringify()` to send data and `.json()` to parse the response from the server.
- **Promises**: `.then()` ensures the UI only updates *after* the server confirms success.

---

## 3. DOM Manipulation & UI Updates

DOM (Document Object Model) manipulation is how we update the visual state of the page based on user actions.

### 3.1. Class Management (`classList`)
In the `toggleLike` function, we change the appearance of the heart icon dynamically:

```javascript
if (data.liked) {
    btn.classList.add("bg-red-500", "text-white", "rounded-full", "p-1");
    btn.classList.remove("text-on-surface-variant");
} else {
    btn.classList.remove("bg-red-500", "text-white", "rounded-full", "p-1");
    btn.classList.add("text-on-surface-variant");
}
```
- **Red Background**: When a user likes a post, we inject Tailwind CSS classes to immediately turn the heart red.
- **Cleanup**: When unliking, we remove those classes to return the icon to its neutral state.

### 3.2. Content Updates (`textContent`)
To keep counts accurate without a reload:
```javascript
const count = document.getElementById(`like-count-${postId}`);
if (count) {
    count.textContent = data.likes_count; // Injects the new number from the server
}
```

---

## 4. Feature Implementation Details

### 4.1. Toggle Like Function
The `toggleLike` function is "dual-purpose." The backend determines if the user has already liked the post:
1. If **already liked**: The record is deleted (Unlike).
2. If **not liked**: A new record is created (Like) and a notification is sent to the author.
The server returns a `liked` boolean and the new `likes_count`.

### 4.2. Commenting System
The commenting system uses a **Modal Pattern**:
1. **Open**: `openCommentsModal()` fetches comments from the server and renders them into the list.
2. **Input**: A `textarea` allows the user to write.
3. **Submit**: `submitCommentModal()` sends the content to `CommentController`.
4. **Refresh**: Upon success, we call `openCommentsModal()` again to instantly show the new comment at the top of the list.

### 4.3. Follow/Unfollow
Similar to likes, but updates the button text from "Follow" to "Unfollow" and swaps the associated event listener on the fly.

---

## 5. Backend Integration (Brief)

- **Controllers**: Handle the business logic (authentication checks, database writes).
- **Models**: Define the relationships (e.g., `Post hasMany Likes`).
- **Notifications**: Laravel's Notification system is used to store high-level "events" in the `notifications` table, which are then displayed in the user's dashboard.

---

## 6. Performance Considerations
- **WithCount**: We use Laravel's `withCount(['comments', 'likes'])` in the controller to ensure count data is eager-loaded, avoiding "N+1" database query issues that would slow down the system.
- **CSRF**: tokens are passed only to protected POST/DELETE routes to maintain security while allowing open GET routes for public viewing.
