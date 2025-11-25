<!-- 💬 Floating Feedback Messenger -->
<div x-data="feedbackChat()" x-init="loadMessages()" class="z-50">
    <!-- Floating Button -->
    <button @click="open = !open"
        class="fixed bottom-6 right-6 bg-[#00ADB5] hover:bg-[#00949b] text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg transition transform hover:scale-105">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M8 10h8m-8 4h5m-8 6h10a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12l2-2h12" />
        </svg>
    </button>

    <!-- Messenger Box -->
    <div x-show="open" x-transition x-cloak
        class="fixed bottom-24 right-6 bg-white w-80 max-h-[70vh] shadow-2xl rounded-2xl flex flex-col overflow-hidden border border-gray-200">

        <!-- Header -->
        <div class="bg-[#00ADB5] text-white px-4 py-3 font-semibold flex justify-between items-center">
            <span>Feedback Chat</span>
            <button @click="open = false" class="text-white hover:text-gray-200">✕</button>
        </div>

        <!-- Messages -->
        <div id="messages" class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50">
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.sender === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <div :class="msg.sender === 'user' ?
                        'bg-[#00ADB5] text-white rounded-2xl px-4 py-2 max-w-[70%]' :
                        'bg-gray-200 text-gray-800 rounded-2xl px-4 py-2 max-w-[70%]'"
                        x-text="msg.message"></div>
                </div>
            </template>
        </div>

        <!-- Input -->
        <form @submit.prevent="sendMessage" class="flex border-t border-gray-300">
            <input type="text" x-model="newMessage" placeholder="Type a message..."
                class="flex-1 px-3 py-2 text-sm outline-none" />
            <button type="submit" class="px-4 text-[#00ADB5] hover:text-[#00949b] font-semibold">Send</button>
        </form>
    </div>
</div>

<script>
     function feedbackChat() {
            return {
                open: false,
                messages: [],
                newMessage: '',

                async loadMessages() {
                    const res = await fetch('/feedback/messages');
                    if (res.ok) {
                        this.messages = await res.json();
                        this.scrollToBottom();
                    }
                },

                async sendMessage() {
                    if (this.newMessage.trim() === '') return;
                    const msg = this.newMessage;
                    this.newMessage = '';

                    // Optimistic UI
                    this.messages.push({
                        sender: 'user',
                        message: msg
                    });
                    this.scrollToBottom();

                    await fetch('/feedback/send', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({
                            message: msg
                        })
                    });

                    this.loadMessages(); // reload full thread
                },

                scrollToBottom() {
                    this.$nextTick(() => {
                        const el = document.getElementById('messages');
                        el.scrollTop = el.scrollHeight;
                    });
                }
            };
        }
</script>
