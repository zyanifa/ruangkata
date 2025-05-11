@props(['user'])

<div {{ $attributes }} x-data="{
    following: {{ $user->isFollowedBy(auth()->user()) ? 'true' : 'false' }},
    followersCount: {{ $user->followers()->count() }},
    isSelf: {{ auth()->check() && auth()->id() === $user->id ? 'true' : 'false' }},
    follow() {
        if (this.isSelf) {
            return; // Prevent following self
        }
        
        axios.post('/follow/{{ $user->id }}')
            .then(res => {
                this.following = !this.following
                this.followersCount = res.data.followersCount
                // Show toast notification
                if (window.showToast) {
                    window.showToast(res.data.message, 'success');
                }
            })
            .catch(err => {
                console.log(err)
            })
    }
}" class="w-[320px] border-l px-8">
    {{ $slot }}
</div>