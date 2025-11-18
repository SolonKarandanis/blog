@auth
    <div x-data="{
            focused: {{ $parentComment ? 'true' : 'false' }},
            init() {
                if (this.isEdit || this.focused)
                    this.$refs.input.focus();

                $wire.on('commentCreated', () => {
                    this.focused = false;
                })
            }
        }">
        <form wire:submit.prevent="createComment">
            <textarea
                x-ref="input"
                @click="focused = true"
                wire:model="body"
                class="w-full rounded-lg p-4 bg-gray-50 dark:bg-gray-600 focus-outline-none text-sm text-gray-900 dark:text-gray-200 border-gray-200 placeholder:text-gray-400"
                cols="30"
                :rows="focused ? '7' : '1'"></textarea>
            <div :class="focused ? '' : 'hidden'">
                <button
                    type="submit"
                    class="mt-3 inline-flex items-center justify-center h-10 px-4 font-medium tracking-wide text-white transition duration-200 bg-gray-700 rounded-lg hover:bg-gray-800 focus:shadow-outline focus:outline-none">
                    Post Comment
                </button>
                <button @click="focused = false; $wire.dispatch('cancelEditing')"
                        type="button"
                        class="mt-3 ml-2 inline-flex items-center justify-center h-10 px-4 font-medium tracking-wide text-white transition duration-200 bg-gray-700 rounded-lg hover:bg-gray-800 focus:shadow-outline focus:outline-none">
                    Cancel
                </button>
            </div>
        </form>
    </div>
@else
    <a wire:navigate class="text-yellow-500 underline py-1" href="{{route('login')}}"> Login to Post Comments</a>
@endauth
