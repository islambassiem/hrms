import { dashboard } from '@/routes';
import { Head } from '@inertiajs/react';
const Dashboard = () => {
    return (
        <>
            <Head title="HR Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                HR Dashboard
            </div>
        </>
    );
};

export default Dashboard;

Dashboard.layout = {
    breadcrumbs: [
        {
            title: 'Dashboard',
            href: dashboard(),
        },
    ],
};
