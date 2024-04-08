<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-beige-accent border border-transparent rounded-md font-semibold text-sm text-grey-700 uppercase tracking-widest hover:bg-beige-accent-hover focus:bg-beige-accent-hover active:bg-beige-accent focus:outline-none focus:ring-2 focus:ring-beige-accent-hover focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
