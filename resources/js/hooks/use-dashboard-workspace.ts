import { useCallback, useSyncExternalStore } from 'react';
import { mockDashboardData, type WorkspaceId } from '@/types/dashboard';

let selectedWorkspace: WorkspaceId = mockDashboardData.initialWorkspace;

const listeners = new Set<() => void>();

const subscribe = (listener: () => void) => {
    listeners.add(listener);

    return () => listeners.delete(listener);
};

const getSnapshot = (): WorkspaceId => selectedWorkspace;

export function useDashboardWorkspace() {
    const workspace = useSyncExternalStore(subscribe, getSnapshot, getSnapshot);

    const updateWorkspace = useCallback((nextWorkspace: WorkspaceId) => {
        if (selectedWorkspace === nextWorkspace) {
            return;
        }

        selectedWorkspace = nextWorkspace;
        listeners.forEach((listener) => listener());
    }, []);

    return [workspace, updateWorkspace] as const;
}
